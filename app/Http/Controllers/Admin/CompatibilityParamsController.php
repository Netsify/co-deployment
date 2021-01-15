<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facilities\CompatibilityParam;
use App\Models\Facilities\CompatibilityParamGroup;
use Illuminate\Http\Request;

class CompatibilityParamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $param_groups = CompatibilityParamGroup::query()->orderByTranslation('name')->get();

        return view('admin.facilities.compatibility_params.form', compact('param_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function show(CompatibilityParam $compatibilityParam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function edit(CompatibilityParam $compatibilityParam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompatibilityParam $compatibilityParam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompatibilityParam $compatibilityParam)
    {
        //
    }
}
