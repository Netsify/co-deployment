<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProposalRequest;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
use App\Models\Project;
use App\Services\FacilitiesCalcService;
use App\Services\ProposalService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Контроллер для работы с предложениями
 *
 * Class ProposalController
 * @package App\Http\Controllers
 */
class ProposalController extends Controller
{
    /**
     * Отображение отправленных предложений
     *
     * @return View
     */
    public function sent(): View
    {
        $proposals = Proposal::with('receiver', 'sender', 'facilities')
            ->where('sender_id', Auth::user()->id)
            ->get();

        $title = __('account.sent_proposals');

        foreach ($proposals as $proposal) {
            $proposal->route_show = route('account.sent-proposals.show', $proposal);
            $proposal->route_destroy = route('account.sent-proposals.destroy', $proposal);
        }

        return view('account.proposals.index', compact('proposals', 'title'));
    }

    /**
     * Отображение входящих предложений
     *
     * @return View
     */
    public function inbox(): View
    {
        $proposals = Proposal::with('receiver', 'sender', 'facilities')
            ->where('receiver_id', Auth::user()->id)
            ->get();

        $title = __('account.inbox');

        foreach ($proposals as $proposal) {
            $proposal->route_show = route('account.inbox.show', $proposal);
            $proposal->route_destroy = route('account.inbox.destroy', $proposal);
        }

        return view('account.proposals.index', compact('proposals', 'title'));
    }

    /**
     * Display the specified resource.
     *
     * @param Proposal $proposal
     * @return View
     */
    public function show(Proposal $proposal): View
    {
        $facilities = $proposal->facilities()
            ->withTrashed()
            ->get()
            ->load('type.translations', 'compatibilityParams.translations', 'user.variables');

        $title = $proposal->sender_id === Auth::user()->id
            ? __('proposal.sent_proposal')
            : __('proposal.incoming_proposal');

        if ($facilities[0]->isDeleted() || $facilities[1]->isDeleted()) {
            return view('account.proposals.show-d', compact('title'));
        }

        $ict_facility = $facilities->filter(function (Facility $facility) {
            return $facility->type->slug == FacilityType::ICT;
        })->first();
        $road_railway_electricity_other_facility = $facilities->filter(function (Facility $facility) {
            return $facility->type->slug != FacilityType::ICT;
        })->first();

        $facilityCalcService = new FacilitiesCalcService();
        $facilityCalcService->setIctFacility($ict_facility);
        $facilityCalcService->setRoadRailwayElectrycityOtherFacility($road_railway_electricity_other_facility);
        $economic_efficiency = $facilityCalcService->getEconomicEfficiency();
        $c_level = $facilityCalcService->getCompatibilityLevel();

        return view('account.proposals.show',
            compact('proposal', 'facilities', 'c_level', 'economic_efficiency', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Proposal $proposal
     * @return RedirectResponse
     */
    public function destroy(Proposal $proposal): RedirectResponse
    {
        try {
            $proposal->deleted_at = Carbon::now();
            $proposal->deleted_by_user_id = Auth::user()->id;

            $proposal->save() === true
                ? Session::flash('message', __('account.proposal_deleted'))
                : throw new \Exception('Не cохранились поля deleted_at, deleted_by_user_id');
        } catch (\Exception $e) {
            Session::flash('error', __('account.errors.deleteProposal'));

            Log::error('Не удалось удалить предложение', [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'proposal' => $proposal->toArray()
            ]);
        }

        return back();
    }

    /**
     * Отправка предложения о сотрудничестве
     *
     * @param Facility $f_of_sender
     * @param Facility $f_of_receiver
     * @param ProposalRequest $request
     * @return RedirectResponse
     */
    public function send(Facility $f_of_sender, Facility $f_of_receiver, ProposalRequest $request)
    {
        $proposal = new Proposal();
        $proposal->description = trim(strip_tags($request->input('description')));
        $proposal->sender_id   = $f_of_sender->user_id;
        $proposal->receiver_id = $f_of_receiver->user_id;

        $proposalService = new ProposalService($proposal);
        $proposalService->attachFacilities(new Collection([$f_of_sender, $f_of_receiver]));

        if ($request->has('attachments')) {
            $proposalService->attachFiles($request->file('attachments'));
        }

        if (!$proposalService->save()) {
            Session::flash('error', __('proposal.errors.store'));
        }

        return redirect()->back();
    }

    /**
     * Отклонить запрос
     *
     * @param Proposal $proposal
     * @return RedirectResponse
     */
    public function decline(Proposal $proposal)
    {
        $proposal->status_id = ProposalStatus::DECLINED;

        if (!$proposal->save()) {
            Log::error("Произошла ошибка при попытке отклонить предложение.", $proposal->toArray());
            Session::flash('error', __('proposal.errors.decline'));

            return redirect()->back();
        }

        return redirect()->route('account.inbox.index');
    }

    public function accept(Proposal $proposal)
    {
        $proposal->load('facilities');
        $title = $proposal->facilities->pluck('title')->implode(' - ');
        $users = new Collection([
            $proposal->receiver,
            $proposal->sender
        ]);

        $facilities = $proposal->facilities;

        $project = new Project(['title' => $title]);
        $project->identifier = Str::random(50);

        try {
            DB::transaction(function () use ($project, $users, $facilities, $proposal) {

                if (!$project->save()) {
                    Log::error('Ошибка создания проекта', [
                        'project' => $project->toArray()
                    ]);

                    Session::flash('error', __('proposal.errors.accept'));

                    return redirect()->back();
                }

                $project->facilities()->attach($facilities);
                $project->users()->attach($users);

                $proposal->status_id = ProposalStatus::ACCEPTED;
                $proposal->save();

                if (!$proposal->save()) {
                    Log::error('Ошибка изменения статуса предложения', [
                        'proposal'      => $proposal->toArray()
                    ]);

                    Session::flash('error', __('proposal.errors.accept'));

                    return redirect()->back();
                }

            });
        } catch (\Exception $e) {
            Log::error('Произошла ошибка при попытке принять предложение о сотрудничестве', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTrace()
            ]);
            Session::flash('error', __('proposal.errors.accept'));

            return redirect()->back();
        }

        return redirect()->route('account.projects.edit', $project);
    }
}
