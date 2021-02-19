<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Класс для перевода групп параметров совместимости объектов
 *
 * Class CompatibilityParamTranslation
 * @package App\Models\Translations
 */
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
