<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * Дата создания комментария
     *
     * @return mixed
     */
    public function getDateAttribute(): mixed
    {
        return $this->created_at->format('d.m.Y');
    }

    /**
     * Пользователь комментариев
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
