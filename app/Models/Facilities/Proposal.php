<?php

namespace App\Models\Facilities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Объекты инфраструктуры
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
}
