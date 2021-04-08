<?php

namespace App\Http\Controllers;

use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Services\FacilitiesCalcService;
use App\Services\FacilitiesSearchService;
use App\Services\FacilitiesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FacilitiesSearchController extends Controller
{
    public function search(Request $request)
    {
        $type = $request->input('type');
        $name_or_id = $request->input('name_or_id');
        $owner = trim(strip_tags($request->input('owner')));

        $my_facility_identificator = abs((int)$request->input('facility'));
        $level = floatval($request->input('level'));

        $facilitiesSearchService = new FacilitiesSearchService();

        if ($name_or_id) {
            $facilitiesSearchService->searcByNameOrID($name_or_id);
        }

        if ($type) {
            $facilitiesSearchService->searchByType($type);
        } else {
            $facilitiesSearchService->searchByAvailableTypes();
        }

        if ($owner) {
            $facilitiesSearchService->searchByOwner($owner);
        }

        $facilitiesSearchService->searchByVisibilities();

        $facilities = $facilitiesSearchService->getSearched();

        if (Gate::allows('use-advanced-search')) {
            if ($my_facility_identificator && $level) {
                $my_facility = Facility::find($my_facility_identificator);
                $facilities->put('my', $my_facility);
                $facilities->load('type.translations', 'user.variables', 'compatibilityParams');
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

                $facilities = $facilities->where('compatibility_level', '>=', $level);
            }
        }

        return view('facilities.search-result', compact('facilities'));
    }
}
