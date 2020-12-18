<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * Класс категорий базы знаний
 *
 * @property int $id
 * @property string $slug        - Уникальный строковый идентификатор
 * @property int $parent_id      - Идентификатор подкатегории
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата редактирования
 *
 * Class Category
 * @package App\Models
 */
class Category extends Model implements TranslatableContract
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
