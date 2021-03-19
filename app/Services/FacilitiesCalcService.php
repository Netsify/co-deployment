<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use Illuminate\Database\Eloquent\Collection;

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

        $variablesService = new VariablesService();
        $groups = $variablesService->getGroups()->load('facilityTypes.translations');

        /*foreach ($groups as $group) {
            echo "<h3>Переменные пользователя " . $this->ict_facility->user->full_name ." для группы: " . $group->getTitle() . '</h3>';
            $variables = $variablesService->forUser($this->ict_facility->user)->get($group);

            foreach ($variables as $variable) {
                echo $variable->id . ' - ' . $variable->slug . ' - ' . $variable->value . '<br>';
            }

            echo "<br>";
        }

        echo "<hr>";

        foreach ($groups as $group) {
            echo "<h3>Переменные пользователя " . $this->road_railway_electricity_other_facility->user->full_name ." для группы: " . $group->getTitle() . '</h3>';
            $variables = $variablesService->forUser($this->road_railway_electricity_other_facility->user)->get($group);

            foreach ($variables as $variable) {
                echo $variable->id . ' - ' . $variable->slug . ' - ' . $variable->value . '<br>';
            }

            echo "<br>";
        }*/

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
}