<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompatibilityParamTranslation extends TranslatableModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description_road',
        'description_railway',
        'description_electricity',
        'description_other',
        'description_ict'
    ];
}
