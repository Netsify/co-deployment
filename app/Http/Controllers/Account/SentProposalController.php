<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
use App\Services\FacilitiesCalcService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SentProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        $proposals = Proposal::with('receiver', 'sender', 'facilities')
            ->where('sender_id', Auth::user()->id)
            ->get();

        return view('account.sent-proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            if ($proposal->delete() === true) {
                $proposal->deleted_by_user_id = Auth::user()->id;

                $proposal->save() === true
                    ? Session::flash('message', __('account.proposal_deleted'))
                    : throw new \Exception('Не сохранен пользователь (отправитель) удаливший предложение');
            } else {
                throw new \Exception('Не удалось удалить предложение отправителем');
            }
        } catch (\Exception $e) {
            Session::flash('error', __('account.errors.deleteProposal'));

            Log::error("Проблемы с удалением предложения отправителем", [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'proposal' => $proposal->toArray()
            ]);
        }

        return back();
    }
}
