<?php

namespace App\Models\Variables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Категорий переменных
 * @property $id;
 * @property string $slug - Идентификатор
 * @property string $name_ru - Имя на русском
 * @property string $name_en - Имя на английском
 * @property Carbon $created_at - Дата создания
 * @property Carbon $updated_at - Дата редактирования
 *
 * @property string $name - Имя (атрибут)
 *
 * Class Category
 * @package App\Models\Variables
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories_of_variables';

    protected $fillable = ['slug', 'name_ru', 'name_en'];

    public function getNameAttribute()
    {
        switch (app()->getLocale()) {
            case 'ru': return $this->name_ru;
            case 'en': return $this->name_en;
        }
    }
}
