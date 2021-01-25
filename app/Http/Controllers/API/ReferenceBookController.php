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
        $property = "description_$facility_type->slug";

        $compatibility_params = CompatibilityParam::query()
            ->orderByTranslation('param_id')
            ->get();
        foreach ($compatibility_params as $param){
            dump($param->$property);
        }
    }
}
