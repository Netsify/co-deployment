<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для перевода категорий
 *
 * @property $name - Название (в нужной локализации)
 *
 * Class CategoryTranslation
 * @package App\Models\Translations
 */
class CategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];
}
