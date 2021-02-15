<?php

namespace App\Models\Variables;

use App\Models\Facilities\FacilityType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups_of_variables';

    public function facilityTypes()
    {
        return $this->belongsToMany(FacilityType::class,
            'facility_type_group_variable', 'group_variable_id');
    }
}
