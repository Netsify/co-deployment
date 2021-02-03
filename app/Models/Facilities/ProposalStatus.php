<?php

namespace App\Models\Facilities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для работы со статусами предложений
 *
 * @property int $id
 * @property string $slug        - Уникальный идентификатор
 * @property string $name        - Название (в нужной локализации)
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата редактирования
 *
 * Class ProposalStatus
 * @package App\Models\Facilities
 */
class ProposalStatus extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * Внешний ключ из таблицы с переводами
     *
     * @var string
     */
    protected $translationForeignKey = 'status_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug'];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['name'];
}
