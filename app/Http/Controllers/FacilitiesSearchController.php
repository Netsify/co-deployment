<?php

namespace App\Http\Controllers;

use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Services\FacilitiesCalcService;
use App\Services\FacilitiesSearchService;
use App\Services\FacilitiesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FacilitiesSearchController extends Controller
{
    public function search(Request $request)
    {
        $facilitiesSearchService = new FacilitiesSearchService();

        if ($request->filled('name_or_id')) {
            $facilitiesSearchService->searcByNameOrID($request->input('name_or_id'));
        }

        if ($request->filled('type')) {
            $facilitiesSearchService->searchByType($request->input('type'));
        } else {
            $facilitiesSearchService->searchByAvailableTypes();
        }

        if ($request->filled('owner')) {
            $facilitiesSearchService->searchByOwner(trim(strip_tags($request->input('owner'))));
        }

        $facilitiesSearchService->searchByVisibilities();

        $facilities = $facilitiesSearchService->getSearched();

        if (Gate::allows('use-advanced-search')) {
            if ($request->input('facility')) {
                $my_facility = Auth::user()->facilities->find($request->input('facility'));
                if (!$my_facility) {
                    abort(404);
                }

                $facilities->put('my', $my_facility);
                $facilities->load('user.variables', 'compatibilityParams');
                $my_facility = $facilities->get('my');
                $facilities->forget('my');

                $collection = new Collection();
                $facilityCalcService = new FacilitiesCalcService();
                if ($my_facility->type->slug == FacilityType::ICT) {
                    $facilityCalcService->setIctFacility($my_facility);

                     foreach ($facilities as $facility) {
                         $facilityCalcService->setRoadRailwayElectrycityOtherFacility($facility);
                         $facility->compatibility_level = $facilityCalcService->getCompatibilityLevel();
                         $facility->economic_efficiency = $facilityCalcService->getEconomicEfficiency();
                         $facility->link = route('facilities.show', $facility->id) . '?my_facility=' . $my_facility->id;
                         $collection->add($facility);
                     }
                } else {
                    $facilityCalcService->setRoadRailwayElectrycityOtherFacility($my_facility);

                    foreach ($facilities as $facility) {
                        $facilityCalcService->setIctFacility($facility);
                        $facility->compatibility_level = $facilityCalcService->getCompatibilityLevel();
                        $facility->economic_efficiency = $facilityCalcService->getEconomicEfficiency();
                        $facility->link = route('facilities.show', $facility->id) . '?my_facility=' . $my_facility->id;
                        $collection->add($facility);
                    }
                }
                $facilities = $collection;

                if ($request->filled('level')) {
                    $facilities = $facilities->where('compatibility_level', '>=', floatval($request->input('level')));
                }

                if ($request->filled('efficiency')) {
                    $facilities = $facilities->where('economic_efficiency', '>=', floatval($request->input('efficiency')));
                }
            }
        }

        return view('facilities.search-result', compact('facilities'));
    }
}
