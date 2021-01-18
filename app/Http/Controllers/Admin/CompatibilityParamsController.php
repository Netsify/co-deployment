<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompatibilityParamRequest;
use App\Models\Facilities\CompatibilityParam;
use App\Models\Facilities\CompatibilityParamGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CompatibilityParamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $param_groups = CompatibilityParamGroup::query()
            ->with('params.translations')
            ->orderByTranslation('param_group_id')
            ->get();

        $form_action = route('admin.facilities.compatibility_params.store');

        return view('admin.facilities.compatibility_params.index', compact('param_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $param_groups = CompatibilityParamGroup::query()->orderByTranslation('name')->get();
        $form_action = route('admin.facilities.compatibility_params.store');

        return view('admin.facilities.compatibility_params.form', compact('param_groups', 'form_action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompatibilityParamRequest $request)
    {
        $data = $request->except('_token');
        $slug = trim(preg_replace('/\s{1,}/', '_', mb_strtolower($data['name']['en'], 'UTF-8')));

        $c_param = [
            'slug'        => $slug,
            'min_val'     => $data['min_val'],
            'max_val'     => $data['max_val'],
            'default_val' => $data['default_val'],
        ];

        foreach ($data['name'] as $locale => $name) {
            $c_param[$locale] = [
                'name'                => $name,
                'description_road'    => $data['road_desc'][$locale],
                'description_railway' => $data['railway_desc'][$locale],
                'description_energy'  => $data['energy_desc'][$locale],
                'description_ict'     => $data['ict_desc'][$locale],
                'description_other'   => $data['other_desc'][$locale],
            ];
        }

        $c_param = new CompatibilityParam($c_param);
        $c_param->group_id = $data['group'];


        if (!$c_param->save()) {
            Log::error('Не удалось сохранить параметр', $request->all());
            Session::flash('error', __('compatibility_param.errors.save'));

            return redirect()->back();
        }

        return redirect()->route('admin.facilities.compatibility_params.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function show(CompatibilityParam $compatibilityParam)
    {
        return view('admin.facilities.compatibility_params.show', compact('compatibilityParam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function edit(CompatibilityParam $compatibilityParam)
    {
        $param_groups = CompatibilityParamGroup::query()->orderByTranslation('name')->get();

        $form_action = route('admin.facilities.compatibility_params.update', $compatibilityParam);

        return view('admin.facilities.compatibility_params.form',
            compact('compatibilityParam', 'param_groups', 'form_action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function update(CompatibilityParamRequest $request, CompatibilityParam $compatibilityParam)
    {
        $data = $request->except(['_token', '_method']);

        $compatibilityParam->group_id = $data['group'];

        foreach (config('app.locales') as $locale) {
            $compatibilityParam->translate($locale)->name = $data['name'][$locale];
            $compatibilityParam->translate($locale)->description_road = $data['road_desc'][$locale];
            $compatibilityParam->translate($locale)->description_railway = $data['railway_desc'][$locale];
            $compatibilityParam->translate($locale)->description_energy = $data['energy_desc'][$locale];
            $compatibilityParam->translate($locale)->description_ict = $data['ict_desc'][$locale];
            $compatibilityParam->translate($locale)->description_other = $data['other_desc'][$locale];
        }

        $compatibilityParam->min_val = $data['min_val'];
        $compatibilityParam->max_val = $data['max_val'];
        $compatibilityParam->default_val = $data['default_val'];

        if (!$compatibilityParam->save()) {
            Log::error('Не удалось сохранить параметр', $request->all());
            Session::flash('error', __('compatibility_param.errors.save'));

            return redirect()->back();
        }

        return redirect()->route('admin.facilities.compatibility_params.show', $compatibilityParam);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facilities\CompatibilityParam  $compatibilityParam
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompatibilityParam $compatibilityParam)
    {
        try {
            if (!$compatibilityParam->delete()) {
                Log::error('Не удалось удалить параметр совместимости', [
                    'c_param' => $compatibilityParam->toArray()
                ]);

                Session::flash('error', __('compatibility_param.errors.delete'));

                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::error('Не удалось удалить параметр совместимости', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTrace(),
                'c_param' => $compatibilityParam->toArray()
            ]);

            Session::flash('error', __('compatibility_param.errors.delete'));

            return redirect()->back();
        }

        return redirect()->route('admin.facilities.compatibility_params.index');
    }
}
