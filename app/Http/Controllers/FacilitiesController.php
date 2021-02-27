<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacilityRequest;
use App\Models\Facilities\CompatibilityParamGroup;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\FacilityVisibility;
use App\Models\File;
use App\Models\Role;
use App\Services\FacilitiesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Контроллер для работы с объектами
 *
 * Class FacilitiesController
 * @package App\Http\Controllers
 */
class FacilitiesController extends Controller
{
    /**
     * @var FacilitiesService
     */
    private $facilityService;

    /**
     * FacilitiesController constructor.
     * @param FacilitiesService $facilityService
     */
    public function __construct(FacilitiesService $facilityService)
    {
        $this->facilityService = $facilityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $facilities = Auth::user()->facilities;
            $facilities->load('type.translations');

            $users_role = Auth::user()->role->slug;
        } else {
            $users_role = null;
            $facilities = null;
        }

        $types = FacilityType::query();

        switch (true) {
            case $users_role == Role::ROLE_ICT_OWNER : $types->where('slug', '!=', 'ict'); break;
            case $users_role == Role::ROLE_ROADS_OWNER : $types->where('slug', 'ict'); break;
        }

        $types = $types->orderByTranslation('name')->get();

        return view('facilities.search-form', compact('facilities', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string|\Illuminate\Http\Response
     */
    public function create()
    {
        $facility = new Facility();

        if (Gate::denies('create', $facility)) {
            abort(403);
        }

/*        $types = FacilityType::query();

        match(true) {
            Auth::user()->role->slug == Role::ROLE_ICT_OWNER => $types->where('slug', 'ict'),
            Auth::user()->role->slug == Role::ROLE_ADMIN => $types,
            default => $types->where('slug', '!=', 'ict'),
        };

        $types = $types->orderByTranslation('name')->get();*/

        $types = FacilityType::orderByTranslation('name')->get();
        dd($types->where('slug', 'ict')->get());

        $visibilities = FacilityVisibility::query()->orderByTranslation('name')->get();
        $compatibility_params = CompatibilityParamGroup::with('params.translations')
            ->orderByTranslation('param_group_id')
            ->get();

        $route = route('account.facilities.store');

        return view('account.facilities.form',
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
     * @param Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function show(Facility $facility)
    {
        if (Gate::denies('view', $facility)) {
            abort(403);
        }

        $facility->load('compatibilityParams.translations');

        $my_facility = request()->input('my_facility');

        $proposal_is_not_exist = false;

        if ($my_facility) {
            $my_facility = Facility::find($my_facility)->load('compatibilityParams.translations');
            FacilitiesService::getCompatibilityRatingByParams($my_facility->compatibilityParams, $facility);

            $proposal_is_not_exist = Auth::user()->proposalIsNotExist($my_facility->id, $facility->id);
        }


        $facility->load('files');

        return view('facilities.show', compact('facility', 'my_facility', 'proposal_is_not_exist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Facility $facility
     * @return View
     */
    public function edit(Facility $facility): View
    {
        $visibilities = FacilityVisibility::query()->orderByTranslation('name')->get();

        $types = FacilityType::all();
        $compatibility_params = CompatibilityParamGroup::with('params.translations')
            ->orderByTranslation('param_group_id')
            ->get();
        $route = route('account.facilities.update', $facility);

        return view('account.facilities.form',
            compact('facility', 'route', 'visibilities', 'types', 'compatibility_params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FacilityRequest $request
     * @param Facility $facility
     * @return RedirectResponse
     */
    public function update(FacilityRequest $request, Facility $facility): RedirectResponse
    {
        $facility->fill($request->validated());

        $facility->type_id = $request->input('type');

        $facility->visibility_id = $request->input('visibility');

        if ($request->has('c_param')) {
            $this->facilityService->attachCompatibilityParams($request->input('c_param'));

            if (!$this->facilityService->setCompatibilityParams($facility)) {
                Log::error("Ошибка при сохранении параметров совместимости", [
                    'facility' => $facility->toArray(),
                    'c_params' => $request->input('c_param'),
                ]);
            }
        }

        if ($request->has('attachments')) {
            $this->facilityService->attachFiles($request->file('attachments'));

            $this->facilityService->storeFiles($facility);
        }

        if ($facility->save()) {
            Session::flash('message', __('facility.facility_updated'));
        } else {
            Session::flash('message', __('facility.errors.facility_not_updated'));

            Log::error('Не удалось обновить объект', compact($facility));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Facility $facility
     * @return RedirectResponse
     */
    public function destroy(Facility $facility): RedirectResponse
    {
        try {
            $facility->delete();
        } catch (\Exception $e) {
            Session::flash('error', __('facility.errors.delete_facility'));

            Log::error("Не удалось удалить объект", [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'facility' => $facility->toArray()
            ]);
        }

        return back();
    }

    /**
     * Отображение и поиск объектов в личном кабинете
     *
     * @param Request $request
     * @return View
     */
    public function accountIndex(Request $request): View
    {
        $facilities = Facility::with('type', 'visibility')
            ->whereHas('user', fn($q) => $q->where('users.id', Auth::user()->id))
            ->get();

        return view('account.facilities.index', compact('facilities'));
    }

    /**
     * Удалить файл у комментария проекта
     *
     * @param Facility $facility
     * @param File $file
     * @return RedirectResponse
     */
    public function deleteFile(Facility $facility, File $file): RedirectResponse
    {
        if (Auth::user()->cannot('userFacilityHasFile', [$facility, $file])) {
            abort(403);
        }

        try {
            $file->delete();
        } catch (\Exception $e) {
            Session::flash('error', __('facility.errors.delete_file'));

            Log::error("Не удалось удалить файл у объекта", [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTrace(),
                'file'    => $file
            ]);
        }

        return back();
    }
}
