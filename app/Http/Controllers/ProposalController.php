<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendProposalRequest;
use App\Models\Facilities\Facility;
use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
use App\Models\Project;
use App\Services\ProposalService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

/**
 * Контроллер для работы с предложениями
 *
 * Class ProposalController
 * @package App\Http\Controllers
 */
class ProposalController extends Controller
{
    /**
     * Отправка предложения о сотрудничестве
     *
     * @param Facility $f_of_sender
     * @param Facility $f_of_receiver
     * @param SendProposalRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Facility $f_of_sender, Facility $f_of_receiver, SendProposalRequest $request)
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
     * @return \Illuminate\Http\RedirectResponse
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
