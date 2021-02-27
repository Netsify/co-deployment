<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facilities\CompatibilityParam;
use App\Models\Facilities\FacilityType;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReferenceBookController extends Controller
{
    public function getDescriptions(FacilityType $facility_type)
    {
        $property = "description_$facility_type->slug";

        $compatibility_params = CompatibilityParam::query()
            ->orderByTranslation('param_id')
            ->get();

        $descriptions = [];
        foreach ($compatibility_params as $param){
            $descriptions[$param->id] = $param->$property;
        }

        return response()->json([
            'status'       => 'ok',
            'descriptions' => $descriptions
        ]);
    }
}
