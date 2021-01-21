<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use HasFactory, Translatable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'parent_id'
    ];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * Возвращает статьи
     *
     * @return HasMany
     */
    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Родительская категория
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Дочерние категории
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
