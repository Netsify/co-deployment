<?php

namespace App\Models\Variables;

use App\Models\Facilities\FacilityType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель групп переменных
 * @property int $id
 * @property string $slug                  - Уникальный идентификатор
 * @property Carbon $created_at            - Дата создания
 * @property Carbon $updated_at            - Дата редактирования
 * @property FacilityType[] $facilityTypes - Типы объектов
 * @property Variable[] $variables         - Переменные
 *
 * Class Group
 * @package App\Models\Variables
 */
class Group extends Model
{
    use HasFactory;

    protected $table = 'groups_of_variables';

    protected $fillable = ['slug'];

    /**
     * Типы объектов
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function facilityTypes() : BelongsToMany
    {
        return $this->belongsToMany(FacilityType::class,
            'facility_type_group_variable', 'group_variable_id', 'facility_type_id');
    }

    /**
     * Переменные
     *
     * @return HasMany
     */
    public function variables() : HasMany
    {
        return $this->hasMany(Variable::class);
    }

    /**
     * Заголовок группы (конкатенируется по параметру
     * )
     * @param string $implode
     * @return mixed
     */
    public function getTitle($implode = ' - ')
    {
        return $this->facilityTypes->pluck('name')->implode($implode);
    }
}
