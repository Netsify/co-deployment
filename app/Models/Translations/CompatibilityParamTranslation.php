<?php

namespace App\Models\Translations;

use App\Models\Facilities\CompatibilityParamDescription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function descriptions()
    {
        return $this->hasMany(CompatibilityParamDescription::class, 'param_translation_id');
    }
}
