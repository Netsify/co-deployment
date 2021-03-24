<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityType;
use App\Models\User;
use App\Models\Variables\Group;
use App\Models\Variables\Variable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * Нужные переменные
     *
     * @var \Illuminate\Support\Collection
     */
    protected $variables;
    public function __construct()
    {
        $this->variables_service = new VariablesService();
        $this->variables_groups = $this->variables_service->getGroups()->load('facilityTypes.translations');
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

        /*
         * Выбрано в зависимости от типа объекта инфраструктуры с которым оценивается объект типа IT
         */
        $sep_group_name = $this->road_railway_electricity_other_facility->type->slug;
        $sep_group = $this->variables_groups->where('slug', 'var_' . $sep_group_name)->first();
        $sep_group_name = ucfirst($sep_group_name);

        /*
         * Выбрано в зависимости от типа объекта инфраструктуры с которым оценивается объект типа IT
         */
        $codep_group_name = $sep_group_name . "+IT";

        /*
         * Переменные из групп Road или Railway или Electricity или Other (теперь можно обращаться по ключу массива)
         */
        $sep_variables = $this->variables_service->forUser(Auth::user())->get($sep_group)->pluck('value', 'slug');

        //В эту переменную будет сложен CAPEX для объектов типа дороги, ЖД, электричества
        //Рассчитывается с использованием подкласса Road. или Railway. или Electricity. или Other. в зависимости от типа
        $capex_road_sep = 0;

        //Затраты на оплату разработки проектной документации
        $Design_LaborNormDesign = $this->getValueOfVariable($sep_group_name . '.Design.LaborNormDesign');
        $Design_LaborCostDesign = $this->getValueOfVariable($sep_group_name.'.Design.LaborCostDesign');
        $Design_NumberOfDesigners = $this->getValueOfVariable($sep_group_name.'.Design.NumberOfDesigners');
        $design_TotalLaborCostDesign = $Design_LaborNormDesign * $Design_LaborCostDesign * $Design_NumberOfDesigners;
        $capex_road_sep += $design_TotalLaborCostDesign;

        //Затраты на разработку сметы строительства
        $Design_LaborNormEstimate = $this->getValueOfVariable($sep_group_name . '.Design.LaborNormEstimate');
        $Design_LaborCostEstimate = $this->getValueOfVariable($sep_group_name . '.Design.LaborCostEstimate');
        $Design_NumberOfEstimators = $this->getValueOfVariable($sep_group_name . '.Design.NumberOfEstimators');

        $design_TotalLaborCostEstimate = $Design_LaborNormEstimate * $Design_LaborCostEstimate * $Design_NumberOfEstimators;
        $capex_road_sep += $design_TotalLaborCostEstimate;

        //Затраты на разработку бизнес-плана (при необходимости, на основании проекта и сметы)
        $Design_LaborNormBP = $this->getValueOfVariable($sep_group_name . '.Design.LaborNormBP');
        $Design_LaborCostBP = $this->getValueOfVariable($sep_group_name . '.Design.LaborCostBP');
        $Design_NumberOfPlanners = $this->getValueOfVariable($sep_group_name . '.Design.NumberOfPlanners');

        $design_TotalLaborCostBP = $Design_LaborNormBP * $Design_LaborCostBP * $Design_NumberOfPlanners;
        $capex_road_sep += $design_TotalLaborCostBP;

        //Затраты на компьютерное моделирование (при необходимости)
        $Design_LaborNormModel = $this->getValueOfVariable($sep_group_name . '.Design.LaborNormModel');
        $Design_LaborCostModel = $this->getValueOfVariable($sep_group_name . '.Design.LaborCostModel');
        $Design_NumberModelers = $this->getValueOfVariable($sep_group_name . '.Design.NumberModelers');

        $design_TotalLaborCostModel = $Design_LaborNormModel*$Design_LaborCostModel*$Design_NumberModelers;
        $capex_road_sep += $design_TotalLaborCostModel;

        //Затраты на разработку макета (при необходимости)
        $Design_LaborNormLayout = $this->getValueOfVariable($sep_group_name . '.Design.LaborNormLayout');
        $Design_LaborCostLayout = $this->getValueOfVariable($sep_group_name . '.Design.LaborCostLayout');
        $Design_NumberOfLayouters = $this->getValueOfVariable($sep_group_name . '.Design.NumberOfLayouters');

        $design_TotalLaborCostLayout = $Design_LaborNormLayout * $Design_LaborCostLayout * $Design_NumberOfLayouters;
        $capex_road_sep += $design_TotalLaborCostLayout;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - PERMITS GROUP
        //Затраты на подготовку пакета документов
        $Permits_LaborNormPack = $this->getValueOfVariable($sep_group_name . '.Permits.LaborNormPack');
        $Permits_LaborCostPack = $this->getValueOfVariable($sep_group_name . '.Permits.LaborCostPack');
        $Permits_NumberPackers = $this->getValueOfVariable($sep_group_name . '.Permits.NumberPackers');

        $permits_TotalLaborCostPack = $Permits_LaborNormPack * $Permits_LaborCostPack * $Permits_NumberPackers;
        $capex_road_sep += $permits_TotalLaborCostPack;

        //Затраты на юридическое сопровождение
        $Permits_LaborNormLegal = $this->getValueOfVariable($sep_group_name . '.Permits.LaborNormLegal');
        $Permits_LaborCostLegal = $this->getValueOfVariable($sep_group_name . '.Permits.LaborCostLegal');
        $Permits_NumberLegals = $this->getValueOfVariable($sep_group_name . '.Permits.NumberLegals');

        $permits_TotalLaborCostLegal = $Permits_LaborNormLegal * $Permits_LaborCostLegal * $Permits_NumberLegals;
        $capex_road_sep += $permits_TotalLaborCostLegal;

        //Затраты на уплату налогов, госпошлин, прочих обязательных платежей
        $Permits_Taxes = $this->getValueOfVariable($sep_group_name . '.Permits.Taxes');
        $capex_road_sep += $Permits_Taxes;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - DIRECT GROUP
        //Закупка материалов в соответствии со сметой
        $Direct_Materials = $this->getValueOfVariable($sep_group_name . '.Direct.Materials');
        $capex_road_sep += $Direct_Materials*$len_fac;

        //Создание резерва материалов (при необходимости)
        $Direct_Reserve = $this->getValueOfVariable($sep_group_name . '.Direct.Reserve');
        $capex_road_sep += ($Direct_Materials * ($Direct_Reserve/100));

        //Приобретение машин и оборудования
        $Direct_Equipment = $this->getValueOfVariable($sep_group_name . '.Direct.Equipment');
        $capex_road_sep += $Direct_Equipment*$len_fac;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - Indirect GROUP
        //Затраты на доставку (один или несколько вариантов)
        //Аренда транспорта
        $Indirect_NumberTransport = $this->getValueOfVariable($sep_group_name . '.Inderect.NumberTransport');
        $Indirect_CostTransportHour = $this->getValueOfVariable($sep_group_name . '.Inderect.CostTransportHour');
        $Indirect_NumberTransportHours = $this->getValueOfVariable($sep_group_name . '.Inderect.NumberTransportHours');
        $indirect_TotalTransport = $Indirect_NumberTransport * $Indirect_CostTransportHour * $Indirect_NumberTransportHours;
        $capex_road_sep += $indirect_TotalTransport;

        //Оплата доставки материалов
        $Indirect_NumberDeliveres = $this->getValueOfVariable($sep_group_name . '.Inderect.NumberDeliveres');
        $Indirect_CostDelivery = $this->getValueOfVariable($sep_group_name . '.Inderect.CostDelivery');
        $indirect_TotalDeliveres = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_road_sep += $indirect_TotalDeliveres;

        //ГСМ для собственного транспорта
        $Indirect_CostFuel = $this->getValueOfVariable($sep_group_name . '.Inderect.CostFuel');
        $Indirect_Mileage = $this->getValueOfVariable($sep_group_name . '.Inderect.Mileage');
        $indirect_TotalFuel = $Indirect_CostFuel * $Indirect_Mileage;
        $capex_road_sep += $indirect_TotalFuel;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - LABOR GROUP
        //Нормы трудозатрат бригады подготовительных работ из расчёта на 1 км
        $Labor_LaborNormPreparation = $this->getValueOfVariable($sep_group_name . '.Labor.LaborNormPreparation');
        $Labor_LaborCostPreparation = $this->getValueOfVariable($sep_group_name . '.Labor.LaborCostPreparation');
        $labor_TotalPreparation = $Labor_LaborNormPreparation * $Labor_LaborCostPreparation*$len_fac;
        $capex_road_sep += $labor_TotalPreparation;

        //Нормы трудозатрат специалистов по дорожному строительству
        $Labor_LaborNormBuilding = $this->getValueOfVariable($sep_group_name . '.Labor.LaborNormBuilding');
        $Labor_LaborCostBuilding = $this->getValueOfVariable($sep_group_name . '.Labor.LaborCostBuilding');
        $labor_TotalBuilding = $Labor_LaborNormBuilding * $Labor_LaborCostBuilding*$len_fac;
        $capex_road_sep += $labor_TotalBuilding;

        //Нормы трудозатрат специалистов по смежным работам
        $Labor_LaborNormAdd = $this->getValueOfVariable($sep_group_name . '.Labor.LaborNormAdd');
        $Labor_LaborCostAdd = $this->getValueOfVariable($sep_group_name . '.Labor.LaborCostAdd');
        $labor_TotalAdd = $Labor_LaborNormAdd * $Labor_LaborCostAdd*$len_fac;
        $capex_road_sep += $labor_TotalAdd;

        //Оплата труда работников социальной сферы
        $Labor_NumberSocialWorkers = $this->getValueOfVariable($sep_group_name . '.Labor.NumberSocialWorkers');
        $Labor_LaborCostSocial = $this->getValueOfVariable($sep_group_name . '.Labor.LaborCostSocial');
        $Labor_LaborNormsSocial = $this->getValueOfVariable($sep_group_name . '.Labor.LaborNormsSocial');
        $labor_TotalSocial = $Labor_NumberSocialWorkers * $Labor_LaborCostSocial * $Labor_LaborNormsSocial;
        $capex_road_sep += $labor_TotalSocial;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - GENERAL GROUP
        //Отчисления в социальные фонды, страхование
        $General_SocialFunds = $this->getValueOfVariable($sep_group_name . '.General.SocialFunds');
        $all_direct_costs = $capex_road_sep;
        $capex_road_sep += ($all_direct_costs * ($General_SocialFunds/100));

        //Накладные расходы, включая расходы на администрирование проекта
        $General_Overhead = $this->getValueOfVariable($sep_group_name . '.General.Overhead');
        $capex_road_sep += ($all_direct_costs * ($General_Overhead/100));

        //НДС
        $General_VAT = $this->getValueOfVariable($sep_group_name . '.General.VAT');
        $capex_road_sep += ($capex_road_sep * ($General_VAT/100));

        /*----------------------------------------------------------------------------*/

        //В эту переменную будет сложен CAPEX для объекта типа ИКТ
        //Рассчитывается с использованием подкласса IT.
        $capex_it_sep = 0;

        //IT - DESIGN GROUP
        //Затраты на оплату разработки проектной документации
        $Design_LaborNormDesign  = $this->getValueOfVariable('IT.Design.LaborNormDesign');
        $Design_LaborCostDesign = $this->getValueOfVariable('IT.Design.LaborCostDesign');
        $Design_NumberOfDesigners = $this->getValueOfVariable('IT.Design.NumberOfDesigners');
        $design_TotalLaborCostDesign = $Design_LaborNormDesign * $Design_LaborCostDesign * $Design_NumberOfDesigners;
        $capex_it_sep += $design_TotalLaborCostDesign;


        //Затраты на разработку сметы строительства
        $Design_LaborNormEstimate = $this->getValueOfVariable('IT.Design.LaborNormEstimate');
        $Design_LaborCostEstimate = $this->getValueOfVariable('IT.Design.LaborCostEstimate');
        $Design_NumberOfEstimators = $this->getValueOfVariable('IT.Design.NumberOfEstimators');
        $design_TotalLaborCostEstimate = $Design_LaborNormEstimate * $Design_LaborCostEstimate * $Design_NumberOfEstimators;
        $capex_it_sep += $design_TotalLaborCostEstimate;

        //Затраты на разработку бизнес-плана (при необходимости, на основании проекта и сметы)
        $Design_LaborNormBP = $this->getValueOfVariable('IT.Design.LaborNormBP');
        $Design_LaborCostBP = $this->getValueOfVariable('IT.Design.LaborCostBP');        
        $Design_NumberOfPlanners = $this->getValueOfVariable('IT.Design.NumberOfPlanners');        
        $design_TotalLaborCostBP = $Design_LaborNormBP * $Design_LaborCostBP * $Design_NumberOfPlanners;
        $capex_it_sep += $design_TotalLaborCostBP;

        //Затраты на закупку или разработку программного обеспечения
        $Design_LaborNormSoftware = $this->getValueOfVariable('IT.Design.LaborNormSoftware');
        $Design_LaborCostSoftware = $this->getValueOfVariable('IT.Design.LaborCostSoftware');
        $Design_NumberDevelopers = $this->getValueOfVariable('IT.Design.NumberDevelopers');
        $design_TotalLaborCostSoftware = $Design_LaborNormSoftware*$Design_LaborCostSoftware*$Design_NumberDevelopers;
        $capex_it_sep += $design_TotalLaborCostSoftware;

        //Затраты на разработку макета (при необходимости)
        /* Этих переменных нет в базе */
//        $Design_LaborNormLayout = $this->getValueOfVariable('IT.Design.LaborNormLayout');
//        $Design_LaborCostLayout = $this->getValueOfVariable('IT.Design.LaborCostLayout');
//        $Design_NumberOfLayouters = $this->getValueOfVariable('IT.Design.NumberOfLayouters');
//        $design_TotalLaborCostLayout = $Design_LaborNormLayout * $Design_LaborCostLayout * $Design_NumberOfLayouters;
//        $capex_it_sep += $design_TotalLaborCostLayout;
        /* Этих переменных нет в базе */

        //IT - PERMITS GROUP
        //Затраты на подготовку пакета документов
        $Permits_LaborNormPack = $this->getValueOfVariable('IT.Permits.LaborNormPack');
        $Permits_LaborCostPack = $this->getValueOfVariable('IT.Permits.LaborCostPack');
        $Permits_NumberPackers = $this->getValueOfVariable('IT.Permits.NumberPackers');
        $permits_TotalLaborCostPack = $Permits_LaborNormPack * $Permits_LaborCostPack * $Permits_NumberPackers;
        $capex_it_sep += $permits_TotalLaborCostPack;

        //Затраты на юридическое сопровождение
        $Permits_LaborNormLegal = $this->getValueOfVariable('IT.Permits.LaborNormLegal');
        $Permits_LaborCostLegal = $this->getValueOfVariable('IT.Permits.LaborCostLegal');
        $Permits_NumberLegals = $this->getValueOfVariable('IT.Permits.NumberLegals');
        $permits_TotalLaborCostLegal = $Permits_LaborNormLegal * $Permits_LaborCostLegal * $Permits_NumberLegals;
        $capex_it_sep += $permits_TotalLaborCostLegal;

        //Затраты на уплату налогов, госпошлин, прочих обязательных платежей
        $Permits_Taxes = $this->getValueOfVariable('IT.Permits.Taxes');
        $capex_it_sep += $Permits_Taxes;

        //Затраты, связанные с получением разрешения на использование радиочастотного ресурса (при необходимости)
        $Permits_Spectrum = 0; //IT.Permits.Spectrum
        $capex_it_sep += $Permits_Spectrum;

        //Затраты на получение разрешения на доступ и строительные работы вдоль дорожного полотна, на временное перекрытие дороги  и т.п.
        $Permits_Access = 0; //IT.Permits.Access
        $capex_it_sep += $Permits_Access;

        //IT - DIRECT GROUP
        //Закупка материалов в соответствии со сметой
        $Direct_Materials = $this->getValueOfVariable('IT.Direct.Materials');
        $capex_it_sep += $Direct_Materials*$len_fac;

        //Создание резерва материалов (при необходимости)
        $Direct_Reserve = $this->getValueOfVariable('IT.Direct.Reserve');
        $capex_it_sep += ($Direct_Materials * ($Direct_Reserve/100));

        //Приобретение машин и оборудования
        $Direct_Equipment = $this->getValueOfVariable('IT.Direct.Equipment');
        $capex_it_sep += $Direct_Equipment*$len_fac;

        //IT - Indirect GROUP
        //Затраты на доставку (один или несколько вариантов)
        //Аренда транспорта
        $Indirect_NumberTransport = $this->getValueOfVariable('IT.Inderect.NumberTransport');
        $Indirect_CostTransportHour = $this->getValueOfVariable('IT.Inderect.CostTransportHour');
        $Indirect_NumberTransportHours = $this->getValueOfVariable('IT.Inderect.NumberTransportHours');
        $indirect_TotalTransport = $Indirect_NumberTransport * $Indirect_CostTransportHour * $Indirect_NumberTransportHours;
        $capex_it_sep += $indirect_TotalTransport;

        //Оплата доставки материалов
        $Indirect_NumberDeliveres = $this->getValueOfVariable('IT.Inderect.NumberDeliveres');
        $Indirect_CostDelivery = $this->getValueOfVariable('IT.Inderect.CostDelivery');
        $indirect_TotalDeliveres = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_it_sep += $indirect_TotalDeliveres;

        //ГСМ для собственного транспорта
        $Indirect_CostFuel = $this->getValueOfVariable('IT.Inderect.CostFuel');
        $Indirect_Mileage = $this->getValueOfVariable('IT.Inderect.Mileage');
        $indirect_TotalFuel = $Indirect_CostFuel * $Indirect_Mileage;
        $capex_it_sep += $indirect_TotalFuel;

        //IT - LABOR GROUP
        //Нормы трудозатрат бригады подготовительных работ из расчёта на 1 км
        $Labor_LaborNormPreparation = $this->getValueOfVariable('IT.Labor.LaborNormPreparation');
        $Labor_LaborCostPreparation = $this->getValueOfVariable('IT.Labor.LaborCostPreparation');
        $labor_TotalPreparation = $Labor_LaborNormPreparation * $Labor_LaborCostPreparation*$len_fac;
        $capex_it_sep += $labor_TotalPreparation;

        //Нормы трудозатрат специалистов по дорожному строительству
        $Labor_LaborNormBuilding = $this->getValueOfVariable('IT.Labor.LaborNormBuilding');
        $Labor_LaborCostBuilding = $this->getValueOfVariable('IT.Labor.LaborCostBuilding');
        $labor_TotalBuilding = $Labor_LaborNormBuilding * $Labor_LaborCostBuilding*$len_fac;
        $capex_it_sep += $labor_TotalBuilding;

        //Нормы трудозатрат специалистов по смежным работам
        $Labor_LaborNormAdd = $this->getValueOfVariable('IT.Labor.LaborNormAdd');
        $Labor_LaborCostAdd = $this->getValueOfVariable('IT.Labor.LaborCostAdd');
        $labor_TotalAdd = $Labor_LaborNormAdd * $Labor_LaborCostAdd*$len_fac;
        $capex_it_sep += $labor_TotalAdd;

        //Оплата труда работников социальной сферы
        $Labor_NumberSocialWorkers = $this->getValueOfVariable('IT.Labor.NumberSocialWorkers');
        $Labor_LaborCostSocial = $this->getValueOfVariable('IT.Labor.LaborCostSocial');
        $Labor_LaborNormsSocial = $this->getValueOfVariable('IT.Labor.LaborNormsSocial');
        $labor_TotalSocial = $Labor_NumberSocialWorkers * $Labor_LaborCostSocial * $Labor_LaborNormsSocial;
        $capex_it_sep += $labor_TotalSocial;


        //IT - GENERAL GROUP
        //Отчисления в социальные фонды, страхование
        $General_SocialFunds = $this->getValueOfVariable('IT.General.SocialFunds');
        $all_direct_costs = $capex_it_sep;
        $capex_it_sep += ($all_direct_costs * ($General_SocialFunds/100));

        //Накладные расходы, включая расходы на администрирование проекта
        $General_Overhead = $this->getValueOfVariable('IT.General.Overhead');
        $capex_it_sep += ($all_direct_costs * ($General_Overhead/100));

        //НДС
        $General_VAT = $this->getValueOfVariable('IT.General.VAT');
        $capex_it_sep += ($capex_it_sep * ($General_VAT/100));

        /*----------------------------------------------------------------------------*/

        //В эту переменную будет сложен CAPEX для объектов совместного развёртівания  дороги, ЖД, электричества с ИКТ
        //Рассчитывается с использованием подкласса подкласса Road+IT. или Railway+IT. или Electricity+IT. или Other+IT. в зависимости от типа
        $capex_road_it_codep = 0;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT  - DESIGN GROUP
        //TODO Тут и далее в ключах (названии) переменных вместо Road+IT должно использоваться значение переменной $codepgroupname - определённой выше

        //Затраты на оплату разработки проектной документации
        $Design_LaborNormDesign  = $this->getValueOfVariable($codep_group_name.'.Design.LaborNormDesign');
        $Design_LaborCostDesign = $this->getValueOfVariable($codep_group_name.'.Design.LaborCostDesign');
        $Design_NumberOfDesigners = $this->getValueOfVariable($codep_group_name.'.Design.NumberOfDesigners');

        $design_TotalLaborCostDesign = $Design_LaborNormDesign * $Design_LaborCostDesign * $Design_NumberOfDesigners;
        $capex_road_it_codep += $design_TotalLaborCostDesign;

        //Затраты на разработку сметы строительства
        $Design_LaborNormEstimate = $this->getValueOfVariable($codep_group_name.'.Design.LaborNormEstimate');
        $Design_LaborCostEstimate = $this->getValueOfVariable($codep_group_name.'.Design.LaborCostEstimate');
        $Design_NumberOfEstimators = $this->getValueOfVariable($codep_group_name.'.Design.NumberOfEstimators'); 

        $design_TotalLaborCostEstimate = $Design_LaborNormEstimate * $Design_LaborCostEstimate * $Design_NumberOfEstimators;
        $capex_road_it_codep += $design_TotalLaborCostEstimate;

        //Затраты на разработку бизнес-плана (при необходимости, на основании проекта и сметы)

        $Design_LaborNormBP = $this->getValueOfVariable($codep_group_name.'.Design.LaborNormBP');
        $Design_LaborCostBP = $this->getValueOfVariable($codep_group_name.'.Design.LaborCostBP');
        $Design_NumberOfPlanners = $this->getValueOfVariable($codep_group_name.'.Design.NumberOfPlanners');

        $design_TotalLaborCostBP = $Design_LaborNormBP * $Design_LaborCostBP * $Design_NumberOfPlanners;
        $capex_road_it_codep += $design_TotalLaborCostBP;

        // Затраты на оплату труда ІТ специалиста

        $Design_LaborNormIT = $this->getValueOfVariable($codep_group_name.'.Design.LaborNormIT');
        $Design_LaborCostIT = $this->getValueOfVariable($codep_group_name.'.Design.LaborCostIT');
        $Design_NumberITStaff = $this->getValueOfVariable($codep_group_name.'.Design.NumberITStaff');

        $design_TotalLaborCostIT = $Design_LaborNormIT*$Design_LaborCostIT*$Design_NumberITStaff;
        $capex_road_it_codep += $design_TotalLaborCostIT;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - PERMITS GROUP
        //Затраты на подготовку пакета документов
        $Permits_LaborNormPack = $this->getValueOfVariable($codep_group_name.'.Permits.LaborNormPack');
        $Permits_LaborCostPack = $this->getValueOfVariable($codep_group_name.'.Permits.LaborCostPack');
        $Permits_NumberPackers = $this->getValueOfVariable($codep_group_name.'.Permits.NumberPackers');

        $permits_TotalLaborCostPack = $Permits_LaborNormPack * $Permits_LaborCostPack * $Permits_NumberPackers;
        $capex_road_it_codep += $permits_TotalLaborCostPack;

        //Затраты на юридическое сопровождение
        $Permits_LaborNormLegal = $this->getValueOfVariable($codep_group_name.'.Permits.LaborNormLegal');
        $Permits_LaborCostLegal = $this->getValueOfVariable($codep_group_name.'.Permits.LaborCostLegal');
        $Permits_NumberLegals = $this->getValueOfVariable($codep_group_name.'.Permits.NumberLegals');

        $permits_TotalLaborCostLegal = $Permits_LaborNormLegal * $Permits_LaborCostLegal * $Permits_NumberLegals;
        $capex_road_it_codep += $permits_TotalLaborCostLegal;

        //Затраты на уплату налогов, госпошлин, прочих обязательных платежей
        $Permits_Taxes = $this->getValueOfVariable($codep_group_name.'.Permits.Taxes');

        $capex_road_it_codep += $Permits_Taxes;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - DIRECT GROUP
        //Закупка материалов в соответствии со сметой
        $Direct_Materials = $this->getValueOfVariable($codep_group_name.'.Direct.Materials');

        $capex_road_it_codep += $Direct_Materials*$len_fac;

        //Создание резерва материалов (при необходимости)
        $Direct_Reserve = $this->getValueOfVariable($codep_group_name.'.Direct.Reserve');
        $capex_road_it_codep += ($Direct_Materials * ($Direct_Reserve/100));

        //Приобретение машин и оборудования
        $Direct_Equipment = $this->getValueOfVariable($codep_group_name.'.Direct.Equipment');

        $capex_road_it_codep += $Direct_Equipment*$len_fac;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - Indirect GROUP
        //Затраты на доставку (один или несколько вариантов)
        //Аренда транспорта
        $Indirect_NumberTransport = $this->getValueOfVariable($codep_group_name.'.Inderect.NumberTransport');
        $Indirect_CostTransportHour = $this->getValueOfVariable($codep_group_name.'.Inderect.CostTransportHour');
        $Indirect_NumberTransportHours = $this->getValueOfVariable($codep_group_name.'.Inderect.NumberTransportHours');

        $indirect_TotalTransport = $Indirect_NumberTransport * $Indirect_CostTransportHour * $Indirect_NumberTransportHours;
        $capex_road_it_codep += $indirect_TotalTransport;

        //Оплата доставки материалов
        $Indirect_NumberDeliveres = $this->getValueOfVariable($codep_group_name.'.Inderect.NumberDeliveres');
        $Indirect_CostDelivery = $this->getValueOfVariable($codep_group_name.'.Inderect.CostDelivery');

        $indirect_TotalDeliveres = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_road_it_codep += $indirect_TotalDeliveres;

        //ГСМ для собственного транспорта
        $Indirect_CostFuel = $this->getValueOfVariable($codep_group_name.'.Inderect.CostFuel');
        $Indirect_Mileage = $this->getValueOfVariable($codep_group_name.'.Inderect.Mileage');

        $indirect_TotalFuel = $Indirect_CostFuel * $Indirect_Mileage;
        $capex_road_it_codep += $indirect_TotalFuel;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - LABOR GROUP
        //Нормы трудозатрат бригады подготовительных работ из расчёта на 1 км
        $Labor_LaborNormPreparation = $this->getValueOfVariable($codep_group_name.'.Labor.LaborNormPreparation');
        $Labor_LaborCostPreparation = $this->getValueOfVariable($codep_group_name.'.Labor.LaborCostPreparation');

        $labor_TotalPreparation = $Labor_LaborNormPreparation * $Labor_LaborCostPreparation*$len_fac;
        $capex_road_it_codep += $labor_TotalPreparation;

        //Нормы трудозатрат специалистов по дорожному строительству
        $Labor_LaborNormBuilding = $this->getValueOfVariable($codep_group_name.'.Labor.LaborNormBuilding');
        $Labor_LaborCostBuilding = $this->getValueOfVariable($codep_group_name.'.Labor.LaborCostBuilding');

        $labor_TotalBuilding = $Labor_LaborNormBuilding * $Labor_LaborCostBuilding*$len_fac;
        $capex_road_it_codep += $labor_TotalBuilding;

        //Нормы трудозатрат специалистов по смежным работам
        $Labor_LaborNormAdd = $this->getValueOfVariable($codep_group_name.'.Labor.LaborNormAdd');
        $Labor_LaborCostAdd = $this->getValueOfVariable($codep_group_name.'.Labor.LaborCostAdd');

        $labor_TotalAdd = $Labor_LaborNormAdd * $Labor_LaborCostAdd*$len_fac;
        $capex_road_it_codep += $labor_TotalAdd;

        //Оплата труда работников социальной сферы
        $Labor_NumberSocialWorkers = $this->getValueOfVariable($codep_group_name.'.Labor.NumberSocialWorkers');
        $Labor_LaborCostSocial = $this->getValueOfVariable($codep_group_name.'.Labor.LaborCostSocial');
        $Labor_LaborNormsSocial = $this->getValueOfVariable($codep_group_name.'.Labor.LaborNormsSocial');

        $labor_TotalSocial = $Labor_NumberSocialWorkers * $Labor_LaborCostSocial * $Labor_LaborNormsSocial;
        $capex_road_it_codep += $labor_TotalSocial;


        //Road+IT, Railway+IT, Electricity+IT, Other+IT - GENERAL GROUP
        //Отчисления в социальные фонды, страхование
        $General_SocialFunds = $this->getValueOfVariable($codep_group_name.'.General.SocialFunds');

        $all_direct_costs = $capex_road_it_codep;

        $capex_road_it_codep += ($all_direct_costs * ($General_SocialFunds/100));

        //Накладные расходы, включая расходы на администрирование проекта
        $General_Overhead = $this->getValueOfVariable($codep_group_name.'.General.Overhead');

        $capex_road_it_codep += ($all_direct_costs * ($General_Overhead/100));

        //НДС
        $General_VAT = $this->getValueOfVariable($codep_group_name.'.General.VAT');
        $capex_road_it_codep += ($capex_road_it_codep * ($General_VAT/100));

        /*----------------------------------------------------------------------------*/

        if ($capex_road_it_codep > 0)
        {
            $economic_efficiency =    ((($capex_road_sep + $capex_it_sep)/$capex_road_it_codep)*100 - 100);
        }


        return round($economic_efficiency, 2); // тут будет число полученное после расчётов
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

    private function getValueOfVariable($variable)
    {
        if (!$this->variables) {
            $vars = new Collection();
            foreach ($this->getVariablesGroups() as $group) {
                $vars = $vars->merge($this->variables_service->forUser(Auth::user())->get($group));
            }
            $this->variables = $vars->pluck('value', 'slug');
        }

        try {
            return $this->variables[$variable];
        } catch (\Exception $e) {
            Log::error("Переменная не найдена", [
                'error' => $e->getMessage(),
                'code'  => $e->getCode(),
                'trace' => $e->getTrace()
            ]);

            return 0;
        }
    }
}