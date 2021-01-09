<?php

namespace App\Models\Facility;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class FacilityVisibility extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug'];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['name'];
}
