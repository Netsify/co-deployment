<?php

namespace App\Http\Controllers;

use App\Models\Facilities\Facility;
use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
use App\Services\ProposalService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function send(Facility $f_of_sender, Facility $f_of_receiver, Request $request)
    {
        $validated = $this->validator($request->except('_token'))->validate();
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
     * Валидация запроса
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'description' => ['required', 'max:1000']
        ]);
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
        dd($proposal);
    }
}
