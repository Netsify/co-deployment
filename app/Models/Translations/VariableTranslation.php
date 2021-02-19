<?php

namespace App\Models\Translations;

/**
 * Класс для перевода переменных
 *
 * Class VariableTranslation
 * @package App\Models\Translations
 */
class VariableTranslation extends TranslatableModel
{
    protected $fillable = ['description', 'unit'];
}
