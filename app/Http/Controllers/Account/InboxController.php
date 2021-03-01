<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
use App\Services\FacilitiesService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        $proposals = Proposal::with('receiver', 'sender', 'facilities')
            ->where('receiver_id', Auth::user()->id)
            ->get();

        $statuses = ProposalStatus::all();

        return view('account.inbox.index', compact('proposals', 'statuses'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal = Proposal::query()->find($id);
        $facilities = $proposal->facilities()->withTrashed()->get()->load('type.translations', 'compatibilityParams.translations');

        if ($facilities[0]->isDeleted() || $facilities[1]->isDeleted()) {
            return view('account.sent-proposals.show-d');
        }

        FacilitiesService::getCompatibilityRatingByParams($facilities[0]->compatibilityParams, $facilities[1]);
        $c_level = $facilities[1]->compatibility_level;

        return view('account.sent-proposals.show', compact('proposal', 'facilities', 'c_level'));
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
     * @param $status
     * @param Proposal $proposal
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Proposal $proposal, $id, $status)
    {
//        echo($status);

//        $proposal->status_id = $status;
//        $proposal->save();

//        if ($proposal->save()) {
//            session()->flash('message', __('account.ProposalSaved'));
//        } else {
//            session()->flash('message', __('account.ProposalNotSaved'));
//
//            Log::error('Не удалось обновить статус предложения', compact('proposal'));
//        }

//        var_dump($proposal->status_id);

//        return response()->json(['success' => true],200);
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
            $proposal->delete();
            $proposal->deleted_at_by_receiver = Carbon::now();
            $proposal->save();
        } catch (\Exception $e) {
            Session::flash('error', __('account.errors.deleteProposal'));

            Log::error("Не удалось удалить предложение получателем", [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'proposal' => $proposal->toArray()
            ]);
        }

        return back();
    }
}
