<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facilities\CompatibilityParam;
use App\Models\Facilities\FacilityType;
use Illuminate\Http\Request;

class ReferenceBookController extends Controller
{
    public function getFacilityTypeDescription(FacilityType $facility_type)
    {
        dump(CompatibilityParam::query()->find(1)->translate()->descriptions);
    }
}
