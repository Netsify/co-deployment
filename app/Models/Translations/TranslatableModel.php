<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Общая модель для транслируемых моделей
 *
 * Class TranslatableModel
 * @package App\Models\Translations
 */
class TranslatableModel extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}
