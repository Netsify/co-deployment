<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariableRequest;
use App\Models\Variables\Category;
use App\Models\Variables\Group;
use App\Models\Variables\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class VariablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::query()->with('variables.translations', 'facilityTypes.translations')->get();

        return view('admin.variables.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variable = new Variable();
        $categories = Category::all();
        $var_types = Variable::VAR_TYPES;
        $groups = Group::query()->with('variables.translations', 'facilityTypes.translations')->get();
        $route = route('admin.facilities.variables.store');

        return view('admin.variables.form',
            compact('variable', 'categories', 'var_types', 'groups', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VariableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariableRequest $request)
    {
        $variable = new Variable([
            'slug' => trim($request->input('name')),
            'min_val' => floatval($request->input('min_val')),
            'max_val' => floatval($request->input('max_val')),
            'default_val' => floatval($request->input('default_val')),
            'type' => strtoupper(trim($request->input('type'))),
            'ru' => [
                'description' => trim($request->input('description.ru')),
                'unit' => trim($request->input('unit.ru'))
            ],
            'en' => [
                'description' => trim($request->input('description.en')),
                'unit' => trim($request->input('unit.en'))
            ],
        ]);
        $variable->category_of_variable_id = $request->input('category');
        $variable->group_id = $request->input('group');

        if (!$variable->save()) {
            Log::error('Ошибка добавления переменной', $request->toArray());

            Session::flash('error', "Не удалось создать переменную. Пожалуйста попробуйте позже");

            return redirect()->back();
        }

        return redirect()->route('admin.facilities.variables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variables\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function show(Variable $variable)
    {
        $categories = Category::all();
        $var_types = Variable::VAR_TYPES;
        $groups = Group::query()->with('variables.translations', 'facilityTypes.translations')->get();
        $route = route('admin.facilities.variables.update', $variable);

        return view('admin.variables.form',
            compact('variable', 'categories', 'var_types', 'groups', 'route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variables\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function edit(Variable $variable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variables\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variable $variable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variables\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variable $variable)
    {
        //
    }
}
