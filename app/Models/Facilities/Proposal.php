<?php

namespace App\Models\Facilities;

use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Предложения пользователей
 *
 * @property int $id
 * @property int $sender_id                  - ИД пользователя отправителя
 * @property int $receiver_id                - ИД пользователя получателя
 * @property int $status_id                  - ИД статуса предложения
 * @property boolean $accepted               - статус
 * @property string $description             - описание и детали
 * @property Carbon $deleted_at_by_receiver  - удалено получателем предложения
 * @property File[] $files                   - Файлы, прикреплённые к предложению о сотрудничестве
 *
 * Class Proposal
 * @package App\Models\Facilities
 */
class Proposal extends Model
{
    use HasFactory, SoftDeletes;

//    /**
//     * Статус пользователя
//     *
//     * @return string
//     */
//    public function getStatusAttribute()
//    {
//        try {
//            return match ($this->accepted) {
//                null => __('proposal.consideration'),
//                0    => __('proposal.rejected'),
//                1    => __('proposal.accepted'),
//            };
//        } catch (\UnhandledMatchError $e) {
//            Log::error('Неправильное значение свойства accepted модели Proposal', [
//                'message' => $e->getMessage(),
//                'code'    => $e->getCode(),
//                'trace'   => $e->getTrace(),
//            ]);
//
//            return __('proposal.wrong_value');
//        }
//    }

    /**
     * Пользователь получатель предложения
     *
     * @return BelongsTo
     */
    public function sender() : BelongsTo
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    /**
     * Пользователь отправитель предложения
     *
     * @return BelongsTo
     */
    public function receiver() : BelongsTo
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    /**
     * Объекты предложения
     *
     * @return BelongsToMany
     */
    public function facilities() : BelongsToMany
    {
        return $this->belongsToMany(Facility::class)->withTimestamps();
    }

    /**
     * Статусы предложения
     *
     * @return HasOne
     */
    public function status() : HasOne
    {
        return $this->hasOne(ProposalStatus::class,'id','status_id');
    }

    /**
     * Файлы, прикреплённые к предложению о сотрудничестве
     *
     * @return MorphMany
     */
    public function files() : MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
