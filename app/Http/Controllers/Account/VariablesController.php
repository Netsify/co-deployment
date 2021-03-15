<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Variables\Group;
use App\Models\Variables\Variable;
use App\Services\VariablesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Контроллер для работы с переменными в аккаунте пользователя
 * 
 * Class VariablesController
 * @package App\Http\Controllers\Account
 */
class VariablesController extends Controller
{
    public function index()
    {
        return redirect()->route('account.variables.list', 1);
    }

    public function list(Group $group)
    {
        $group->load('facilityTypes.translations');

        $variablesService = new VariablesService(Auth::user());
        $variables = $variablesService->get($group);

        $groups = Group::query()->where('id', '!=',  $group->id)
            ->with('facilityTypes.translations')->get();

        return view('account.facilities.variables', compact('groups', 'group', 'variables'));
    }

    public function storeForUser(Group $group, Request $request)
    {
        $variablesService = new VariablesService(Auth::user());

        try {
            $variablesService->storeForUser($request->input('variable'), $group);
        } catch (\Exception $e) {
            Log::error('Не удалось сохранить переменные для пользователя. ', [
                'message'   => $e->getMessage(),
                'code'      => $e->getCode(),
                'trace'     => $e->getTrace(),
                'user'      => Auth::user()->toArray(),
                'variables' => $request->input('variable')
            ]);

            Session::flash('error', __('variable.errors.store_for_user'));
        }
        return redirect()->back();
    }
}
