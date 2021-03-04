<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Variables\Group;
use App\Models\Variables\Variable;
use Illuminate\Http\Request;

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
        $groups = Group::query()->with('facilityTypes.translations')->get();

        return view('account.facilities.variables', compact('groups'));
    }
    
    public function update(Variable $variable)
    {
        dd($variable);
    }
}
