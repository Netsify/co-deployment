<?php

namespace App\Models;

use App\Models\Facilities\Facility;
use App\Models\Facilities\Proposal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Проекты предложений
 *
 * @property int $id
 * @property string $title                      - Название проекта
 * @property string $description                - Описание проекта
 * @property string $identifier                 - Идентификатор приглашения дизайнеров
 * @property int $status_id                     - ИД статуса
 * @property Carbon $created_at                 - создано
 * @property Carbon $updated_at                 - обновлено
 *
 * Class Project
 * @package App\Models
 */
class Project extends Model
{
    use HasFactory;

    /**
     * Дата начала проекта
     *
     * @return mixed
     */
    public function getStartingDateAttribute(): mixed
    {
        return $this->created_at->format('d.m.Y');
    }

    /**
     * Статусы предложения
     *
     * @return BelongsTo
     */
    public function proposal() : BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * Статусы предложения
     *
     * @return HasOne
     */
    public function status() : HasOne
    {
        return $this->hasOne(ProjectStatus::class,'id','status_id');
    }

    /**
     * Участники проекта
     *
     * @return BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Объекты проекта
     *
     * @return BelongsToMany
     */
    public function facilities() : BelongsToMany
    {
        return $this->belongsToMany(Facility::class)->withTimestamps();
    }

    /**
     * Комментарии проекта
     *
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
