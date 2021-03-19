<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\User;
use App\Models\Variables\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Сервис для расчётов связанных с объектами
 *
 * Class FacilitiesCalcService
 * @package App\Services
 */
class FacilitiesCalcService
{
    /**
     * Объект типа дорога, жд, электричество или другое
     *
     * @var Facility
     */
    protected $road_railway_electricity_other_facility;

    /**
     * Объект типа икт
     *
     * @var Facility
     */
    protected $ict_facility;

    /**
     * Сервис для работы с переменными
     *
     * @var VariablesService
     */
    protected $variables_service;

    /**
     * Группы переменных
     *
     * @var Group[]
     */
    protected $variables_groups;

    /**
     * Пользователь которого берём переменные
     *
     * @var User
     */
    protected $user;

    public function __construct()
    {
        $this->variables_service = new VariablesService();
        $this->variables_groups = $this->variables_service->getGroups()->load('facilityTypes.translations');
        $this->user = Auth::user();
    }

    /**
     * Устанавливаем объект типа дорога и тд
     * 
     * @param Facility $facility
     */
    public function setRoadRailwayElectrycityOtherFacility(Facility $facility): void
    {
        $this->road_railway_electricity_other_facility = $facility;
    }

    /**
     * Устанавливаем объект типа икт
     * 
     * @param Facility $ict_facility
     */
    public function setIctFacility(Facility $ict_facility): void
    {
        $this->ict_facility = $ict_facility;
    }

    /**
     * Получаем экономическую эффективность
     *
     * @return float
     */
    public function getEconomicEfficiency()
    {
        $economic_efficiency = 0;

        /*
         * Минимальная длина
         */
        $len_fac = $this->getMinLength();
        echo "<p>Минимальная длина = $len_fac</p>";

        foreach ($this->getVariablesGroups() as $group) {
            echo "<h3>Переменные пользователя " . $this->user->full_name ." для группы: " . $group->getTitle() . '</h3>';
            $variables = $this->variables_service->forUser($this->user)->get($group);

            foreach ($variables as $variable) {
                echo $variable->id . ' - ' . $variable->slug . ' - ' . $variable->value . '<br>';
            }

            echo "<br>";
        }

        echo "<hr>";

        return $economic_efficiency; // итог
    }

    /**
     * Получаем минимальную длину из двух объектов
     *
     * @return float
     */
    protected function getMinLength() : float
    {
        $ict_len = $this->ict_facility->length;
        $rreo_len = $this->road_railway_electricity_other_facility->length;
        return $ict_len <= $rreo_len ? $ict_len : $rreo_len;
    }

    /**
     * Получаем уровень совместимости между двумя объектами
     *
     * @return float
     */
    public function getCompatibilityLevel() : float
    {
        $array = [];
        $sum = 0;

        $param_ids = $this->ict_facility->compatibilityParams->pluck('group_id', 'id');

        foreach ($param_ids as $param_id => $group) {
            $array[$group][] = $this->getAbsDivBetweenSameParam($param_id);
        }

        foreach ($array as $value) {
            $sum += array_sum($value) / count($value);
        }

        return round($sum / count($array), 2);
    }

    /**
     * Получаем абсолютное число из разности двух схожих параметров
     *
     * @param int $param_id
     * @return int
     */
    private function getAbsDivBetweenSameParam(int $param_id) : int
    {
        return abs($this->ict_facility->compatibilityParams->find($param_id)->pivot->value - $this->road_railway_electricity_other_facility->compatibilityParams->find($param_id)->pivot->value);
    }

    /**
     * Получаем коллекцию нужных групп переменных
     *
     * @return Collection|Group[]
     */
    private function getVariablesGroups() : Collection
    {
        $types = [
            'var_' . FacilityType::ICT,
            'var_' . $this->road_railway_electricity_other_facility->type->slug,
            'var_' . FacilityType::ICT . '_' . $this->road_railway_electricity_other_facility->type->slug
        ];

        return $this->variables_groups->whereIn('slug', $types);
    }
}