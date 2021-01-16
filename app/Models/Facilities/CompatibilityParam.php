<?php

namespace App\Models\Facilities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель параметров совместимости объектов
 * @property int $id;
 * @property string $slug - Уникальный идентификатор
 * @property int $group_id - ИД группы параметров
 * @property int $min_val - Минимальное значение
 * @property int $max_val - Максимальное значение
 * @property int $default_val - Значение по умолчанию
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата изменения
 *
 * Class CompatibilityParam
 * @package App\Models\Facilities
 */
class CompatibilityParam extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * Внешний ключ из таблицы с переводами
     *
     * @var string
     */
    protected $translationForeignKey = 'param_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'min_val', 'max_val', 'default_val'];

    /**
     * Поля, которые должны быть переведены
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description_road',
        'description_railway',
        'description_energy',
        'description_ict',
        'description_other'
    ];

}
