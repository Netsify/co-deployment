<?php

namespace App\Models\Facilities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


/**
 * Класс для работы с видимостью объектов
 * @property int $id
 * @property string $slug        - Уникальный идентификатор
 * @property string $name        - Название (в нужной локализации)
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата редактирования
 *
 * Class FacilityVisibility
 * @package App\Models\Facilities
 */
class FacilityVisibility extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    const ONLY_FOR_ME = 'only_for_me';
    const FOR_REGISTERED = 'for_registered';
    const FOR_ALL = 'for_all';

    /**
     * Внешний ключ из таблицы с переводами
     *
     * @var string
     */
    protected $translationForeignKey = 'visibility_id';
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
