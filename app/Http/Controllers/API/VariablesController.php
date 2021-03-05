<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Variables\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VariablesController extends Controller
{
    public function getByGroup(Request $request)
    {
        $group_id = $request->input('group');

        $user = User::query()->find(3);

        $variables = Variable::query()->where('group_id', $group_id)->orderByTranslation('description')->get();
        $user_variables = $user->variables()->where('group_id', $group_id)->orderByTranslation('description')->get();

        $array = [];
        foreach ($variables as $key => $variable) {
            $arr = [
                'id' => $variable->id,
                'description' => $variable->description,
                'unit' => $variable->unit
            ];
           if ($user_variables->contains($variable)) {
               $arr['value'] = $user_variables->find($variable->id)->pivot->value;
           } else {
               $arr['value'] = $variable->default_val;
           }

           $array[] = $arr;
        }

        return response()->json([
            'status'    => 'ok',
            'variables' => $array
        ]);
    }
}
