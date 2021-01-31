<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacilityRequest;
use App\Models\Facilities\CompatibilityParamGroup;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\FacilityVisibility;
use App\Models\Role;
use App\Services\FacilitiesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Контроллер для работы с объектами
 *
 * Class FacilitiesController
 * @package App\Http\Controllers
 */
class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Auth::user()->facilities;
        $facilities->load('type.translations');
        $facility_types = FacilityType::query()->orderByTranslation('name')->get();

        return view('facilities.search-form', compact('facilities', 'facility_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string|\Illuminate\Http\Response
     */
    public function create()
    {
        $facility = new Facility();
        $types = FacilityType::query();
        $types = match(true) {
            Auth::user()->role->slug == Role::ROLE_ICT_OWNER => $types->where('slug', 'ict'),
            Auth::user()->role->slug == Role::ROLE_ADMIN => $types,
            default => $types->where('slug', '!=', 'ict'),
        };
        $types = $types->orderByTranslation('name')->get();
        $visibilities = FacilityVisibility::query()->orderByTranslation('name')->get();
        $compatibility_params = CompatibilityParamGroup::with('params.translations')
            ->orderByTranslation('param_group_id')
            ->get();

        $route = route('facilities.store');

        return view('facilities.form',
            compact('facility', 'types', 'visibilities', 'route', 'compatibility_params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FacilityRequest $request)
    {
        $identitficator = Str::random(rand(20, 50));

        $facility = new Facility($request->only('title', 'description', 'location'));
        $facility->type_id = $request->input('type');
        $facility->visibility_id = $request->input('visibility');
        $facility->setIdentificator($identitficator);
        $facility->setLocale(app()->getLocale());

        $c_params = $request->input('c_param');

        $facilityService = new FacilitiesService($facility, $c_params);

        if($request->has('attachments')) {
            $facilityService->attachFiles($request->file('attachments'));
        }

        if ($facilityService->store()) {
            return redirect()->route('facilities.index');
        }

        Session::flash('error', __('facility.errors.store'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facilities\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facilities\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function edit(Facility $facility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facilities\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facility $facility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facilities\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facility $facility)
    {
        //
    }

    public function search()
    {
        dd(1);
    }
}
