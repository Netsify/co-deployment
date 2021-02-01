<?php

namespace App\Http\Controllers;

use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\FacilityVisibility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilitiesSearchController extends Controller
{
    protected function searcByNameOrID(EloquentBuilder &$builder, $name_or_id)
    {
        $builder->where(function (EloquentBuilder $query) use ($name_or_id) {
            $query->where('title', 'like', "%$name_or_id%")
                ->orWhere('identificator', $name_or_id);
        });
    }

    protected function searchByType(EloquentBuilder &$builder, $type)
    {
        $builder->where('type_id', function (Builder $query) use ($type) {
            $query->select('id')
                ->from((new FacilityType())->getTable())
                ->where('slug', $type);
        });
    }

    protected function searchByAvailableTypes(EloquentBuilder &$builder)
    {
        switch (true) {
            case Auth::user()->role->slug == Role::ROLE_ICT_OWNER :
                $builder->whereIn('type_id', function (Builder $query) {
                    $query->select('id')->from((new FacilityType())->getTable())
                        ->where('slug', '!=', Role::ROLE_ICT_OWNER);
                });
                break;
            case Auth::user()->role->slug == Role::ROLE_ADMIN :
                $builder;
                break;
            default :
                $builder->where('type_id', function (Builder $query) {
                    $query->select('id')->from((new FacilityType())->getTable())
                        ->where('slug', Role::ROLE_ICT_OWNER);
                });
                break;
        }
    }

    protected function searchByVisibilities(EloquentBuilder &$builder)
    {
        $builder->whereIn('visibility_id', function (Builder $query) {
            $query->select('id')
                ->from((new FacilityVisibility())->getTable())
                ->whereIn('slug', [FacilityVisibility::FOR_REGISTERED, FacilityVisibility::FOR_ALL]);
        });
    }

    protected function searchByOwner(EloquentBuilder &$builder, $owner)
    {
        $builder->whereIn('user_id', function (Builder $query) use ($owner) {
            $query->select('id')
                ->from((new User())->getTable())
                ->whereRaw("CONCAT (first_name, ' ', last_name) LIKE ?", "%$owner%");
        });
    }

    public function search(Request $request)
    {
        $type = $request->input('type');
        $name_or_id = $request->input('name_or_id');
        $facilities = Facility::query();
        $owner = trim(strip_tags($request->input('owner')));

        if ($name_or_id) {
            $this->searcByNameOrID($facilities, $name_or_id);
        }

        if ($type) {
            $this->searchByType($facilities, $type);
        } else {
            $this->searchByAvailableTypes($facilities);
        };

        if ($owner) {
            $this->searchByOwner($facilities, $owner);
        }

        $this->searchByVisibilities($facilities);

        dump($facilities->get());
    }
}
