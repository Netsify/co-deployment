<?php

namespace App\Models\Variables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Variable extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    const VARIABLE_TYPE_INTEGER = 'INT';
    const VARIABLE_TYPE_FLOAT = 'FLOAT';

    const VAR_TYPES = [
        self::VARIABLE_TYPE_INTEGER,
        self::VARIABLE_TYPE_FLOAT
    ];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['description', 'unit'];
}
