<?php

namespace App\Models\Facilities;

use App\Models\Variables\Group;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Класс типов объектов
 *
 * @property int $id
 * @property string $slug        - Уникальный строковый идентификатор
 * @property Carbon $created_at  - Дата создания
 * @property Carbon $updated_at  - Дата редактирования
 * @property Group $variablesGroups - Группы переменных
 *
 * Class Category
 * @package App\Models\Facilities
 */
class FacilityType extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    const ROAD = 'road';
    const ICT = 'ict';
    const ELECTRICITY = 'electricity';
    const RAILWAY = 'railway';
    const OTHER = 'other';

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

    /**
     * Группы переменных этого типа
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function variablesGroups() : BelongsToMany
    {
        return $this->belongsToMany(Group::class,
            'facility_type_group_variable', 'facility_type_id', 'group_variable_id');
    }
}
