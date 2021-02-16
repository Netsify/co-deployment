<?php

namespace App\Models\Variables;

use App\Models\Facilities\FacilityType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель групп переменных
 * @property int $id
 * @property string $slug - Уникальный идентификатор
 * @property Carbon $created_at - Дата создания
 * @property Carbon $updated_at - Дата редактирования
 * @property FacilityType[] - Типы объектов
 * Class Group
 * @package App\Models\Variables
 */
class Group extends Model
{
    use HasFactory;

    protected $table = 'groups_of_variables';

    protected $fillable = ['slug'];

    public function facilityTypes()
    {
        return $this->belongsToMany(FacilityType::class,
            'facility_type_group_variable', 'group_variable_id', 'facility_type_id');
    }
}
