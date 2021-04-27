<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\Proposal;
use App\Services\FacilitiesCalcService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * Контроллер для работы с предложениями
 *
 * Class ProposalController
 * @package App\Http\Controllers
 */
class InboxController extends Controller
{
    /**
     * Отображение отправленных предложений
     *
     * @return View
     */
    public function sent() : View
    {
        $proposals = Proposal::with('receiver', 'sender', 'facilities')
            ->where('sender_id', Auth::user()->id)
            ->get();

        return view('account.sent-proposals.index', compact('proposals'));
    }

    /**
     * Отображение входящих предложений
     *
     * @return View
     */
    public function inbox() : View
    {
        $proposals = Proposal::with('receiver', 'sender', 'facilities')
            ->where('receiver_id', Auth::user()->id)
            ->get();

        return view('account.inbox.index', compact('proposals'));
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

        if ($facilities[0]->isDeleted() || $facilities[1]->isDeleted()) {
            return view('account.sent-proposals.show-d');
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

        return view('account.sent-proposals.show',
            compact('proposal', 'facilities', 'c_level', 'economic_efficiency'));
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
}
