<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Класс статей базы знаний
 *
 * @property int $id
 * @property int $user_id              - ИД пользователя
 * @property int $category_id          - ИД категории
 * @property string $title             - Заголовок
 * @property string $content           - Содержание
 * @property boolean $published        - Статус
 * @property boolean $checked_by_admin - Проверен ли админом
 * @property Carbon $created_at        - Дата создания
 * @property Carbon $updated_at        - Дата изменения
 * @property Carbon $deleted_at        - Дата удаления
 * @property User $user                - Пользователь
 * @property Tag[] $tags               - Теги к статье
 * @property Category $category        - Категория
 * @property string $preview           - Короткое превью контента
 *
 * Class Article
 * @package App\Models
 */
class Article extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Спецсимволы которые могут попасться
     *
     * @var array
     */
    private $special_chars = ['&nbsp;'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content'];

    /**
     * Пользователь создавший статью
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Теги к статье
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Возвращает категорию
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Файлы к статье
     *
     * @return MorphMany
     */
    public function files() : MorphMany
    {
        return $this->MorphMany(File::class, 'fileable');
    }

    /**
     * Превью статьи
     * @return string
     */
    public function getPreviewAttribute()
    {
        $preview =trim(strip_tags(str_replace($this->special_chars, ' ', $this->content)));
        return mb_substr($preview, 0, 50, 'UTF-8');
    }

    /**
     * Опубликованные статьи
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query) : Builder
    {
        return $query->where('published', 1)->where('checked_by_admin', 1);
    }

    /**
     * Отклонённые или удалённые статьи
     *
     * @return Builder
     */
    public function scopeRejectedAndDeleted() : Builder
    {
        return $this->onlyTrashed()->orWhere('published', 0);
    }

    /**
     * Непроверенные статьи
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnchecked(Builder $query) : Builder
    {
        return $query->where('checked_by_admin', 0);
    }
}
