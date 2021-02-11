<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

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
     * Комментарии пользователя
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
