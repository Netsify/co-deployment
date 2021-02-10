<?php

namespace App\Models;

use App\Models\Facilities\Proposal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
