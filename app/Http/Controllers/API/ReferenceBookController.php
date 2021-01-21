<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facilities\CompatibilityParam;
use App\Models\Facilities\CompatibilityParamDescription;
use App\Models\Facilities\FacilityType;
use Illuminate\Http\Request;

class ReferenceBookController extends Controller
{
    public function getFacilityTypeDescription(FacilityType $facility_type)
    {
//        dump($facility_type);
        $c_params = CompatibilityParam::query()->orderByTranslation('param_id')->get();

        foreach ($c_params as  $param) {
            dump($param->translate()->descriptions()->where('type_id', $facility_type->id)->get());
        }
    }

    public function create ()
    {
        $c_param = new CompatibilityParam();
        $c_param->slug = "test";
        $c_param->group_id = 1;
        $c_param->min_val = 0;
        $c_param->max_val = 5;
        $c_param->default_val = 3;

        $names = ['ru' => "Тест", 'en' => "Test"];

        $descriptions = [
            1 => ['ru' => "дорога описание", 'en' => "road description"],
            2 => ['ru' => "икт описание", 'en' => "ict description"],
            3 => ['ru' => "электричество описание", 'en' => "electricity description"],
            4 => ['ru' => "жд описание", 'en' => "railway description"],
            5 => ['ru' => "другое описание", 'en' => "other description"],
        ];

        foreach (config('app.locales') as $locale) {
            $c_param->translateOrNew($locale)->name = $names[$locale];
            $c_param->save();
            $descs = [];
            foreach ($descriptions as $type_id => $description) {
                $desc = new CompatibilityParamDescription();
                $desc->description = $description[$locale];
                $desc->type_id = $type_id;
                $descs[] = $desc;
            }
            $c_param->translate($locale)->descriptions()->saveMany($descs);
        }

        dump($c_param);
    }
}
