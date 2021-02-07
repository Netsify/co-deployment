<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facilities\CompatibilityParam;
use App\Models\Facilities\CompatibilityParamGroup;
use Illuminate\Http\Request;

class CompatibilityParamsController extends Controller
{
    public function index()
    {
        $types =

        $params = CompatibilityParamGroup::with('params.translations')
            ->orderByTranslation('param_group_id')
            ->get();

        return response()->json(['data' => $params]);
    }
}
