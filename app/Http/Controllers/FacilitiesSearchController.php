<?php

namespace App\Http\Controllers;

use App\Services\FacilitiesSearchService;
use Illuminate\Http\Request;

class FacilitiesSearchController extends Controller
{
    public function search(Request $request)
    {
        $type = $request->input('type');
        $name_or_id = $request->input('name_or_id');
        $owner = trim(strip_tags($request->input('owner')));
        $facilitiesSearchService = new FacilitiesSearchService();

        if ($name_or_id) {
            $facilitiesSearchService->searcByNameOrID($name_or_id);
        }

        if ($type) {
            $facilitiesSearchService->searchByType($type);
        } else {
            $facilitiesSearchService->searchByAvailableTypes();
        };

        if ($owner) {
            $facilitiesSearchService->searchByOwner($owner);
        }

        $facilitiesSearchService->searchByVisibilities();

        $facilities = $facilitiesSearchService->getSearched()->load('type', 'user');

        return view('facilities.search-result', compact('facilities'));
    }
}
