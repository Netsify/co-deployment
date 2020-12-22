<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Класс статей базы знаний
 *
 * @property int $id
 * @property int $user_id           - ИД пользователя
 * @property int $category_id       - ИД категории
 * @property string $title          - Заголовок
 * @property string $content        - Содержание
 * @property boolean $published     - Статус
 * @property Carbon $created_at     - Дата создания
 * @property Carbon $updated_at     - Дата изменения
 * @property Carbon $deleted_at     - Дата удаления
 * @property User $user             - Пользователь
 * @property Tag[] $tags            - Теги к статье
 * @property Category $category     - Категория
 * @property string $preview        - Короткое превью контента
 *
 * Class Article
 * @package App\Models
 */
class Article extends Model
{
    use HasFactory, SoftDeletes;

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
     * Превью статьи
     * @return string
     */
    public function getPreviewAttribute()
    {
        return mb_substr(strip_tags($this->content), 0, 50, 'UTF-8');
    }
}
