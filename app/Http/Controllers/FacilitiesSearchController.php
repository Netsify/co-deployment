<?php

namespace App\Http\Controllers;

use App\Models\Facilities\Facility;
use App\Services\FacilitiesSearchService;
use App\Services\FacilitiesService;
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

                FacilitiesService::getCompatibilityRating($my_facility, $facilities);
                $facilities = $facilities->where('compatibility_level', '<=', $level);
            }
        }

        return view('facilities.search-result', compact('facilities'));
    }
}
