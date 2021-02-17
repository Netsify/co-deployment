<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variables\Category;
use App\Models\Variables\Group;
use App\Models\Variables\Variable;
use Illuminate\Http\Request;

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

        return view('admin.variables.form', compact('variable', 'categories', 'var_types', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $variable = new Variable([
            'slug' => trim(strip_tags($request->input('name'))),
            'min_val' => floatval($request->input('min_val')),
            'max_val' => floatval($request->input('max_val')),
            'default_val' => floatval($request->input('default_val')),
            'type' => strtoupper(trim(strip_tags($request->input('type')))),
            'ru' => [
                'description' => trim(strip_tags($request->input('description.ru'))),
                'unit' => trim(strip_tags($request->input('unit.ru')))
            ],
            'en' => [
                'description' => trim(strip_tags($request->input('description.en'))),
                'unit' => trim(strip_tags($request->input('unit.en')))
            ],
        ]);
        $variable->category_of_variable_id = $request->input('category');
        $variable->group_id = $request->input('group');

        $variable->save();

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
        //
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
