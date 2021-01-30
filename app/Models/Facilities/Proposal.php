<?php

namespace App\Models\Facilities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Предложения пользователей
 *
 * @property int $id
 * @property int $sender_id                  - ИД пользователя отправителя
 * @property int $receiver_id                - ИД пользователя получателя
 * @property boolean $accepted               - статус
 * @property string $description             - описание и детали
 *
 * Class Proposal
 * @package App\Models\Facilities
 */
class Proposal extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Пользователи получатели предложения
     *
     * @return HasMany
     */
    public function receivers() : HasMany
    {
        return $this->hasMany(User::class, 'receiver_id');
    }

    /**
     * Объекты предложения
     *
     * @return HasMany
     */
    public function facilities() : HasMany
    {
        return $this->hasMany(Facility::class);
    }
}
