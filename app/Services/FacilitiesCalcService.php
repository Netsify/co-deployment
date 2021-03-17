<?php

namespace App\Services;
use App\Models\Facilities\Facility;

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
        /*
         * Минимальная длина
         */
        $len_fac = $this->getMinLength();

        $variablesService = new VariablesService();
        $groups = $variablesService->getGroups()->load('facilityTypes.translations');
        foreach ($groups as $group) {
            echo "<h4>Переменные пользователя " . $this->ict_facility->user->full_name ." для группы: " . $group->getTitle() . '<br>';
            $variables = $variablesService->forUser($this->ict_facility->user)->get($group);
            foreach ($variables as $variable) {
                echo $variable->id . ' - ' . $variable->slug . ' - ' . $variable->value . '<br>';
            }
            echo "<hr>";
        }

        return 10; // итог
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
}