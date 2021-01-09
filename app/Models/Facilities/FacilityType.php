<?php

namespace App\Models\Facilities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс типов объектов
 *
 * @property int $id
 * @property string $slug        - Уникальный строковый идентификатор
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата редактирования
 *
 * Class Category
 * @package App\Models\Facilities
 */
class FacilityType extends Model implements TranslatableContract
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
