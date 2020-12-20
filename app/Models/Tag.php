<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс тегов статей базы знаний
 *
 * @property int $id
 * @property string $tag        - Тег
 * @property Carbon $created_at - Дата создания тега
 * @property Carbon $updated_at - Дата изменения тега
 *
 * Class Tag
 * @package App\Models
 */
class Tag extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =['tag'];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

}
