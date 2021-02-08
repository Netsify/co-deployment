<?php

namespace App\Http\Controllers;

use App\Models\Facilities\Facility;
use App\Models\Facilities\Proposal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProposalController extends Controller
{
    public function send(Facility $f_of_sender, Facility $f_of_receiver, Request $request)
    {
        $collection = new Collection();
        $collection->put('f_of_sender', $f_of_sender);
        $collection->put('f_of_receiver', $f_of_receiver);

        $proposal = new Proposal();
        $proposal->description = trim(strip_tags($request->input('description')));
        $proposal->sender_id   = $f_of_sender->user_id;
        $proposal->receiver_id = $f_of_receiver->user_id;

        if ($proposal->save()) {
            if (!$proposal->facilities()->sync($collection)) {
                Log::error('Не удалось прикрепить объекты к предложению', [
                    'facility_collection' => $collection->toArray()
                ]);
            }
        } else {
            Log::error("Не удалось создать предложение", [
                'request' => $request->except('_token'),
                'facility_collection' => $collection->toArray()
            ]);
        }

        return redirect()->back();
    }
}
