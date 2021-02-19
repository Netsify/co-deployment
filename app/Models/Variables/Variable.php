<?php

namespace App\Models\Variables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Класс переменных для экономической эффективности
 * @property int $id
 * @property string $slug - Имя переменной (уникальный идентификатор)
 * @property float $min_val - Минимальное значение
 * @property float $max_val - Максимальное значение
 * @property float $default_val - Значение по умолчанию
 * @property string $type - Тип переменной
 * @property int $group_id - ИД группы
 * @property int $category_of_variable_id - ИД категории
 * @property Carbon $created_at - Дата создания
 * @property Carbon $updated_at - Дата редактирования
 *
 * Class Variable
 * @package App\Models\Variables
 */
class Variable extends Model implements TranslatableContract
{
    use HasFactory, Translatable, SoftDeletes;

    const VARIABLE_TYPE_INTEGER = 'INT';
    const VARIABLE_TYPE_FLOAT = 'FLOAT';

    const VAR_TYPES = [
        self::VARIABLE_TYPE_INTEGER,
        self::VARIABLE_TYPE_FLOAT
    ];

    protected $fillable = ['slug', 'min_val', 'max_val', 'default_val', 'type'];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['description', 'unit'];
}
