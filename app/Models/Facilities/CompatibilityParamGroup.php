<?php

namespace App\Models\Facilities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс групп параметров совместимости объектов
 *
 * @property int $id;
 * @property string $slug - уникальный идентификатор
 * @property string $name - Название (в нужной локале)
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата изменения
 * @property CompatibilityParam[] $params - Параметры
 *
 * Class CompatibilityParamGroup
 * @package App\Models\Facilities
 */
class CompatibilityParamGroup extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * Внешний ключ из таблицы с переводами
     *
     * @var string
     */
    protected $translationForeignKey = 'param_group_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =['slug'];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * Параметры
     *
     * @return HasMany
     */
    public function params() : HasMany
    {
        return $this->hasMany(CompatibilityParam::class, 'group_id');
    }
}
