<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\Facilities\FacilityVisibility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Сервис для работы с поиском по объектам инфраструктуры
 *
 * Class FacilitiesSearchService
 * @package App\Services
 *
 */
class FacilitiesSearchService
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * FacilitiesSearchService constructor.
     */
    public function __construct()
    {
        $this->builder = Facility::query();
    }

    /**
     * Поиск с указанием имени или идентификатора объекта
     *
     * @param $name_or_id
     */
    public function searcByNameOrID($name_or_id)
    {
        $this->builder->where(function (EloquentBuilder $query) use ($name_or_id) {
            $query->where('title', 'like', "%$name_or_id%")
                ->orWhere('identificator', $name_or_id);
        });
    }

    /**
     * Поиск с указанием типа объекта
     *
     * @param $type
     */
    public function searchByType($type)
    {
        $this->builder->where('type_id', function (Builder $query) use ($type) {
            $query->select('id')
                ->from((new FacilityType())->getTable())
                ->where('slug', $type);
        });
    }

    /**
     * Поиск объектов противоположного типа если тип не указан
     */
    public function searchByAvailableTypes()
    {
        switch (true) {
            case Auth::user()->role->slug == Role::ROLE_ICT_OWNER :
                $this->builder->whereIn('type_id', function (Builder $query) {
                    $query->select('id')->from((new FacilityType())->getTable())
                        ->where('slug', '!=', Role::ROLE_ICT_OWNER);
                });
                break;
            case Auth::user()->role->slug == Role::ROLE_ADMIN :
                $this->builder;
                break;
            default :
                $this->builder->where('type_id', function (Builder $query) {
                    $query->select('id')->from((new FacilityType())->getTable())
                        ->where('slug', Role::ROLE_ICT_OWNER);
                });
                break;
        }
    }

    /**
     * Поиск по типу отображения объекта
     */
    public function searchByVisibilities()
    {
        $this->builder->whereIn('visibility_id', function (Builder $query) {
            $query->select('id')
                ->from((new FacilityVisibility())->getTable())
                ->whereIn('slug', [FacilityVisibility::FOR_REGISTERED, FacilityVisibility::FOR_ALL]);
        });
    }

    /**
     * Поиск по владельцу объекта
     *
     * @param $owner
     */
    public function searchByOwner($owner)
    {
        $this->builder->whereIn('user_id', function (Builder $query) use ($owner) {
            $query->select('id')
                ->from((new User())->getTable())
                ->whereRaw("CONCAT (first_name, ' ', last_name) LIKE ?", "%$owner%");
        });
    }

    /**
     * Возвращаем найденные объекты
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSearched()
    {
        return $this->builder->get();
    }
}