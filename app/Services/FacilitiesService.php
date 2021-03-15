<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Сервис для работы с объектами инфраструктуры
 *
 * Class FacilitiesService
 * @package App\Services
 */
class FacilitiesService
{
    /**
     * Объект
     *
     * @var Facility
     */
    private $_facility;

    /**
     * Приклеплённые файлы
     *
     * @var array
     */
    private $_attachments = [];

    /**
     * Параметры совместимости
     *
     * @var array
     */
    private $_c_params = [];

    /**
     * Конструктор
     *
     * FacilitiesService constructor.
     * @param Facility $facility
     * @param array|null $c_params
     */
    public function __construct(Facility $facility, array $c_params = null)
    {
        $this->_facility = $facility;
        $this->_c_params = $c_params;
    }

    /**
     * Приклепляем файлы
     *
     * @param array $attachments
     */
    public function attachFiles(array $attachments)
    {
        $this->_attachments = $attachments;
    }

    /**
     * Прикрепляем параметры совместимости
     *
     * @param array $compatibilityParams
     */
    public function attachCompatibilityParams(array $compatibilityParams)
    {
        $this->_c_params = $compatibilityParams;
    }

    /**
     * Создание объекта
     *
     * @return bool
     */
    public function store() : bool
    {
        $facility = Auth::user()->facilities()->save($this->_facility);

        if ($facility) {
            if (!$this->setCompatibilityParams($this->_facility)) {
                Log::error("Ошибка при сохранении параметров совместимости", [
                    'facility' => $facility->toArray(),
                    'c_params' => $this->_c_params,
                ]);
            }

            if (!empty($this->_attachments)) {
                return $this->storeFiles($facility);
            }

            return true;
        }

        Log::error("Не удалось создать объект", [
            'facility' => $this->_facility->toArray()
        ]);

        return false;
    }

    /**
     * Сохранение приклеплённых файлов
     *
     * @param Facility $facility
     * @return bool
     */
    public function storeFiles(Facility $facility) : bool
    {
        $files = [];

        foreach ($this->_attachments as $attachment) {
            $file = new File();
            $file->name = $attachment->getClientOriginalName();
            $file->path = $attachment->store('facilities');

            $files[] = $file;
        }

        if (!$facility->files()->saveMany($files)) {
            Log::error("Не удалось прикрепить файлы к объекту", [
                'facility'    => $facility->toArray(),
                'attachments' => $files
            ]);

            return false;
        }

        return true;
    }

    /**
     * Устанавливаем или обновляем параметры совместимости
     *
     * @param Facility $facility
     * @return bool
     */
    public function setCompatibilityParams(Facility $facility): bool
    {
        $cParams = [];

        foreach ($this->_c_params as $id => $value) {
            $cParams[$id] = ['value' => $value];
        }

        if ($facility->compatibilityParams()->sync($cParams,false)) {
            return true;
        }

        return false;
    }

    /**
     * Метод задаёт параметры совместимости для объектов в коллекции с которыми сравнивается выбранный объект
     *
     * @param Facility $facility
     * @param Collection $objects
     */
    public static function getCompatibilityRating(Facility $facility, Collection &$objects)
    {
        $facility->load('compatibilityParams.translations');
        $f_params = $facility->compatibilityParams;
        $objects->load('compatibilityParams.translations');
            foreach ($objects as $key => $object) {
                $object->compatibility_level = self::getCompatibilityRatingByParams($f_params, $object);
                $objects[$key] = $object;
            }

    }

    /**
     * Метод задаёт параметр совместимости для объекта с которым сравнивается выбранный объект пользователя
     *
     * @param Collection $my_facility_c_params
     * @param Facility $facility     *
     *
     * @return float
     */
    public static function getCompatibilityRatingByParams(Collection $my_facility_c_params, Facility $facility)
    {
        $param_ids = $my_facility_c_params->pluck('group_id', 'id');
        $facility_c_params = $facility->compatibilityParams;

        $array = [];
        foreach ($param_ids as $param_id => $group) {
            $div = $facility_c_params->find($param_id)->pivot->value - $my_facility_c_params->find($param_id)->pivot->value;
            $div = abs($div);
            $array[$group][] = $div;
        }

        $sum = 0;
        foreach ($array as $value) {
            $sum += array_sum($value) / count($value);
        }

        return round($sum / count($array), 2);
    }

    /**
     * Метод задаёт экономическую эффективность между объектами
     *(Вадим, этот метод Вам)
     *
     * @param Facility $facility1
     * @param Facility $facility2
     * @return int
     */
    public static function getEconomicEfficiency(Facility $facility1, Facility $facility2)
    {
        $economic_efficiency = 0;
        //Если гет параметр show_array = true то отображатся два массива
        if (\request()->has('show_array') && \request()->input('show_array') === 'true') {
            /*
             * Скорее всего Вам будут нужны ключи title, slug, value, description
             * */
            echo "User " . $facility1->user->full_name;
            dump($facility1->variablesGroups);
            echo "User " . $facility2->user->full_name;
            dd($facility2->variablesGroups);
        }

        //Supergroupnames identification
        //$sepgroupname = "Road"; // Должно быть выбрано в зависимости от типа объекта инфраструктуры с которым оценивается объект типа IT
        //Road, Railway, Electricity, Other
        //$codepgroupname = "Road+IT"; // Должно быть выбрано в зависимости от типа объекта инфраструктуры с которым оценивается объект типа IT
        //Road+IT, Railway+IT, Electricity+IT, Other+IT

        /*
         * Вот тут мне нужна помощь по организации правильного доступа к значениям
         * Я не совсем понимаю какой объект какой  (в $facility1 - дороги, в $facility2 - ИТ)?
         * Сюда всегда должно попадать два противоположных - дорога и ИТ, ЖД и ИТ, Электро и ИТ, Другое и ИТ
         * Т.е. ИТ и ИТ или Дорога и Дорога сюда попасть никак не должны
         *
         * Я не очень понимаю почему мы берём переменные из разных объектов?
         * Ещё раз - переменные относятся к юзеру, а не к объекту и у любого юзера есть полный набор
         * Т.е. я - владелец дороги - считаю экономику опираясь на свои значения переменных, которые я повводил в том числе и для ИТ
         * А от самих объектов мне по факту нужны только тип первого объекта (дорога он или что там),
         * так как тип второго всегда ИТ и ещё - мне нужна такая штука как длина объекта (протяжённость)
         * Вот тут мне в принципе нужно min из двух длин
         * Т.е. если протяженность дороги 100 км, а волокна 50 км, то мне нужно вернуть 50км
         * */

        $len_fac = 0;

        /*----------------------------------------------------------------------------*/
        
        //В эту переменную будет сложен CAPEX для объектов типа дороги, ЖД, электричества
        //Рассчитывается с использованием подкласса Road. или Railway. или Electricity. или Other. в зависимости от типа
        $capex_road_sep = 0;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - DESIGN GROUP
        //TODO Тут и далее в ключах (названии) переменных вместо Road должно использоваться значение переменной $sepgroupname - определённой выше
        //Т.е. как-то так variables[$sepgroupname.".Design.LaborNormDesign"];

        //Затраты на оплату разработки проектной документации
        $Design_LaborNormDesign  = 0;//        Road.Design.LaborNormDesign
        $Design_LaborCostDesign = 0; //        Road.Design.LaborCostDesign
        $Design_NumberOfDesigners = 0;//        Road.Design.NumberOfDesigners

        $design_TotalLaborCostDesign = $Design_LaborNormDesign * $Design_LaborCostDesign * $Design_NumberOfDesigners;
        $capex_road_sep += $design_TotalLaborCostDesign;

        //Затраты на разработку сметы строительства
        $Design_LaborNormEstimate = 0; //        Road.Design.LaborNormEstimate
        $Design_LaborCostEstimate = 0;//        Road.Design.LaborCostEstimate
        $Design_NumberOfEstimators = 0; //        Road.Design.NumberOfEstimators

        $design_TotalLaborCostEstimate = $Design_LaborNormEstimate * $Design_LaborCostEstimate * $Design_NumberOfEstimators;
        $capex_road_sep += $design_TotalLaborCostEstimate;

        //Затраты на разработку бизнес-плана (при необходимости, на основании проекта и сметы)

        $Design_LaborNormBP = 0;//        Road.Design.LaborNormBP
        $Design_LaborCostBP = 0;//        Road.Design.LaborCostBP
        $Design_NumberOfPlanners = 0;//        Road.Design.NumberOfPlanners

        $design_TotalLaborCostBP = $Design_LaborNormBP * $Design_LaborCostBP * $Design_NumberOfPlanners;
        $capex_road_sep += $design_TotalLaborCostBP;

        //Затраты на компьютерное моделирование (при необходимости)

        $Design_LaborNormModel = 0;//        Road.Design.LaborNormModel
        $Design_LaborCostModel = 0;//        Road.Design.LaborCostModel
        $Design_NumberModelers = 0;//        Road.Design.NumberModelers

        $design_TotalLaborCostModel = $Design_LaborNormModel*$Design_LaborCostModel*$Design_NumberModelers;
        $capex_road_sep += $design_TotalLaborCostModel;

        //Затраты на разработку макета (при необходимости)
        $Design_LaborNormLayout = 0;//        Road.Design.LaborNormLayout
        $Design_LaborCostLayout = 0;//        Road.Design.LaborCostLayout
        $Design_NumberOfLayouters = 0;//        Road.Design.NumberOfLayouters

        $design_TotalLaborCostLayout = $Design_LaborNormLayout * $Design_LaborCostLayout * $Design_NumberOfLayouters;
        $capex_road_sep += $design_TotalLaborCostLayout;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - PERMITS GROUP
        //Затраты на подготовку пакета документов
        $Permits_LaborNormPack = 0;//        Road.Permits.LaborNormPack
        $Permits_LaborCostPack = 0;//        Road.Permits.LaborCostPack
        $Permits_NumberPackers = 0;//        Road.Permits.NumberPackers

        $permits_TotalLaborCostPack = $Permits_LaborNormPack * $Permits_LaborCostPack * $Permits_NumberPackers;
        $capex_road_sep += $permits_TotalLaborCostPack;

        //Затраты на юридическое сопровождение
        $Permits_LaborNormLegal = 0;//        Road.Permits.LaborNormLegal
        $Permits_LaborCostLegal = 0;//        Road.Permits.LaborCostLegal
        $Permits_NumberLegals = 0;//        Road.Permits.NumberLegals

        $permits_TotalLaborCostLegal = $Permits_LaborNormLegal * $Permits_LaborCostLegal * $Permits_NumberLegals;
        $capex_road_sep += $permits_TotalLaborCostLegal;

        //Затраты на уплату налогов, госпошлин, прочих обязательных платежей
        $Permits_Taxes = 0;//        Road.Permits.Taxes

        $capex_road_sep += $Permits_Taxes;


        //ROAD, RAILWAY, ELECTRICITY, OTHER - DIRECT GROUP
        //Закупка материалов в соответствии со сметой
        $Direct_Materials = 0;//        Road.Direct.Materials

        $capex_road_sep += $Direct_Materials*$len_fac;

        //Создание резерва материалов (при необходимости)
        $Direct_Reserve = 0;//        Road.Direct.Reserve

        $capex_road_sep += ($Direct_Materials * ($Direct_Reserve/100));

        //Приобретение машин и оборудования
        $Direct_Equipment = 0;//        Road.Direct.Equipment

        $capex_road_sep += $Direct_Equipment*$len_fac;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - Indirect GROUP
        //Затраты на доставку (один или несколько вариантов)
        //Аренда транспорта
        $Indirect_NumberTransport = 0;//        Road.Indirect.NumberTransport
        $Indirect_CostTransportHour = 0;//        Road.Indirect.CostTransportHour
        $Indirect_NumberTransportHours = 0;//        Road.Indirect.NumberTransportHours

        $indirect_TotalTransport = $Indirect_NumberTransport * $Indirect_CostTransportHour * $Indirect_NumberTransportHours;
        $capex_road_sep += $indirect_TotalTransport;

        //Оплата доставки материалов
        $Indirect_NumberDeliveres = 0;//        Road.Indirect.NumberDeliveres
        $Indirect_CostDelivery = 0;//        Road.Indirect.CostDelivery

        $indirect_TotalDeliveres = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_road_sep += $indirect_TotalDeliveres;

        //ГСМ для собственного транспорта
        $Indirect_CostFuel = 0;//        Road.Indirect.CostFuel
        $Indirect_Mileage = 0;//        Road.Indirect.Mileage

        $indirect_TotalFuel = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_road_sep += $indirect_TotalFuel;

        //ROAD, RAILWAY, ELECTRICITY, OTHER - LABOR GROUP
        //Нормы трудозатрат бригады подготовительных работ из расчёта на 1 км
        $Labor_LaborNormPreparation = 0;//        Road.Labor.LaborNormPreparation
        $Labor_LaborCostPreparation = 0;//        Road.Labor.LaborCostPreparation

        $labor_TotalPreparation = $Labor_LaborNormPreparation * $Labor_LaborCostPreparation*$len_fac;
        $capex_road_sep += $labor_TotalPreparation;

        //Нормы трудозатрат специалистов по дорожному строительству
        $Labor_LaborNormBuilding = 0;//        Road.Labor.LaborNormBuilding
        $Labor_LaborCostBuilding = 0;//        Road.Labor.LaborCostBuilding

        $labor_TotalBuilding = $Labor_LaborNormBuilding * $Labor_LaborCostBuilding*$len_fac;
        $capex_road_sep += $labor_TotalBuilding;

        //Нормы трудозатрат специалистов по смежным работам
        $Labor_LaborNormAdd = 0;//        Road.Labor.LaborNormAdd
        $Labor_LaborCostAdd = 0;//        Road.Labor.LaborCostAdd

        $labor_TotalAdd = $Labor_LaborNormAdd * $Labor_LaborCostAdd*$len_fac;
        $capex_road_sep += $labor_TotalAdd;

        //Оплата труда работников социальной сферы
        $Labor_NumberSocialWorkers = 0;//        Road.Labor.NumberSocialWorkers
        $Labor_LaborCostSocial = 0;//        Road.Labor.LaborCostSocial
        $Labor_LaborNormsSocial = 0;//        Road.Labor.LaborNormsSocial

        $labor_TotalSocial = $Labor_NumberSocialWorkers * $Labor_LaborCostSocial * $Labor_LaborNormsSocial;
        $capex_road_sep += $labor_TotalSocial;


        //ROAD, RAILWAY, ELECTRICITY, OTHER - GENERAL GROUP
        //Отчисления в социальные фонды, страхование
        $General_SocialFunds = 0;//        Road.General.SocialFunds

        $all_direct_costs = $capex_road_sep;

        $capex_road_sep += ($all_direct_costs * ($General_SocialFunds/100));

        //Накладные расходы, включая расходы на администрирование проекта
        $General_Overhead = 0;//        Road.General.Overhead

        $capex_road_sep += ($all_direct_costs * ($General_Overhead/100));

        //НДС
        $General_VAT = 0;//        Road.General.VAT
        $capex_road_sep += ($capex_road_sep * ($General_VAT/100));

        /*----------------------------------------------------------------------------*/
        
        //В эту переменную будет сложен CAPEX для объекта типа ИКТ
        //Рассчитывается с использованием подкласса IT.
        $capex_it_sep = 0;


        //IT - DESIGN GROUP
        //Затраты на оплату разработки проектной документации
        $Design_LaborNormDesign  = 0;//        IT.Design.LaborNormDesign
        $Design_LaborCostDesign = 0; //        IT.Design.LaborCostDesign
        $Design_NumberOfDesigners = 0;//        IT.Design.NumberOfDesigners

        $design_TotalLaborCostDesign = $Design_LaborNormDesign * $Design_LaborCostDesign * $Design_NumberOfDesigners;
        $capex_it_sep += $design_TotalLaborCostDesign;

        //Затраты на разработку сметы строительства
        $Design_LaborNormEstimate = 0; //        IT.Design.LaborNormEstimate
        $Design_LaborCostEstimate = 0;//        IT.Design.LaborCostEstimate
        $Design_NumberOfEstimators = 0; //        IT.Design.NumberOfEstimators

        $design_TotalLaborCostEstimate = $Design_LaborNormEstimate * $Design_LaborCostEstimate * $Design_NumberOfEstimators;
        $capex_it_sep += $design_TotalLaborCostEstimate;

        //Затраты на разработку бизнес-плана (при необходимости, на основании проекта и сметы)

        $Design_LaborNormBP = 0;//        IT.Design.LaborNormBP
        $Design_LaborCostBP = 0;//        IT.Design.LaborCostBP
        $Design_NumberOfPlanners = 0;//        IT.Design.NumberOfPlanners

        $design_TotalLaborCostBP = $Design_LaborNormBP * $Design_LaborCostBP * $Design_NumberOfPlanners;
        $capex_it_sep += $design_TotalLaborCostBP;

        //Затраты на закупку или разработку программного обеспечения

        $Design_LaborNormSoftware = 0;//        IT.Design.LaborNormSoftware
        $Design_LaborCostSoftware = 0;//        IT.Design.LaborCostSoftware
        $Design_NumberDevelopers = 0;//        IT.Design.NumberDevelopers

        $design_TotalLaborCostSoftware = $Design_LaborNormSoftware*$Design_LaborCostSoftware*$Design_NumberDevelopers;
        $capex_it_sep += $design_TotalLaborCostSoftware;

        //Затраты на разработку макета (при необходимости)
        $Design_LaborNormLayout = 0;//        IT.Design.LaborNormLayout
        $Design_LaborCostLayout = 0;//        IT.Design.LaborCostLayout
        $Design_NumberOfLayouters = 0;//        IT.Design.NumberOfLayouters

        $design_TotalLaborCostLayout = $Design_LaborNormLayout * $Design_LaborCostLayout * $Design_NumberOfLayouters;
        $capex_it_sep += $design_TotalLaborCostLayout;

        //IT - PERMITS GROUP
        //Затраты на подготовку пакета документов
        $Permits_LaborNormPack = 0;//        IT.Permits.LaborNormPack
        $Permits_LaborCostPack = 0;//        IT.Permits.LaborCostPack
        $Permits_NumberPackers = 0;//        IT.Permits.NumberPackers

        $permits_TotalLaborCostPack = $Permits_LaborNormPack * $Permits_LaborCostPack * $Permits_NumberPackers;
        $capex_it_sep += $permits_TotalLaborCostPack;

        //Затраты на юридическое сопровождение
        $Permits_LaborNormLegal = 0;//        IT.Permits.LaborNormLegal
        $Permits_LaborCostLegal = 0;//        IT.Permits.LaborCostLegal
        $Permits_NumberLegals = 0;//        IT.Permits.NumberLegals

        $permits_TotalLaborCostLegal = $Permits_LaborNormLegal * $Permits_LaborCostLegal * $Permits_NumberLegals;
        $capex_it_sep += $permits_TotalLaborCostLegal;

        //Затраты на уплату налогов, госпошлин, прочих обязательных платежей
        $Permits_Taxes = 0;//        IT.Permits.Taxes

        $capex_it_sep += $Permits_Taxes;

        //Затраты, связанные с получением разрешения на использование радиочастотного ресурса (при необходимости)
        $Permits_Spectrum = 0; //IT.Permits.Spectrum
        $capex_it_sep += $Permits_Spectrum;

        //Затраты на получение разрешения на доступ и строительные работы вдоль дорожного полотна, на временное перекрытие дороги  и т.п.
        $Permits_Access = 0; //IT.Permits.Access
        $capex_it_sep += $Permits_Access;

        //IT - DIRECT GROUP
        //Закупка материалов в соответствии со сметой
        $Direct_Materials = 0;//        IT.Direct.Materials

        $capex_it_sep += $Direct_Materials*$len_fac;

        //Создание резерва материалов (при необходимости)
        $Direct_Reserve = 0;//        IT.Direct.Reserve

        $capex_it_sep += ($Direct_Materials * ($Direct_Reserve/100));

        //Приобретение машин и оборудования
        $Direct_Equipment = 0;//        IT.Direct.Equipment

        $capex_it_sep += $Direct_Equipment*$len_fac;

        //IT - Indirect GROUP
        //Затраты на доставку (один или несколько вариантов)
        //Аренда транспорта
        $Indirect_NumberTransport = 0;//        IT.Indirect.NumberTransport
        $Indirect_CostTransportHour = 0;//        IT.Indirect.CostTransportHour
        $Indirect_NumberTransportHours = 0;//        IT.Indirect.NumberTransportHours

        $indirect_TotalTransport = $Indirect_NumberTransport * $Indirect_CostTransportHour * $Indirect_NumberTransportHours;
        $capex_it_sep += $indirect_TotalTransport;

        //Оплата доставки материалов
        $Indirect_NumberDeliveres = 0;//        IT.Indirect.NumberDeliveres
        $Indirect_CostDelivery = 0;//        IT.Indirect.CostDelivery

        $indirect_TotalDeliveres = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_it_sep += $indirect_TotalDeliveres;

        //ГСМ для собственного транспорта
        $Indirect_CostFuel = 0;//        IT.Indirect.CostFuel
        $Indirect_Mileage = 0;//        IT.Indirect.Mileage

        $indirect_TotalFuel = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_it_sep += $indirect_TotalFuel;

        //IT - LABOR GROUP
        //Нормы трудозатрат бригады подготовительных работ из расчёта на 1 км
        $Labor_LaborNormPreparation = 0;//        IT.Labor.LaborNormPreparation
        $Labor_LaborCostPreparation = 0;//        IT.Labor.LaborCostPreparation

        $labor_TotalPreparation = $Labor_LaborNormPreparation * $Labor_LaborCostPreparation*$len_fac;
        $capex_it_sep += $labor_TotalPreparation;

        //Нормы трудозатрат специалистов по дорожному строительству
        $Labor_LaborNormBuilding = 0;//        IT.Labor.LaborNormBuilding
        $Labor_LaborCostBuilding = 0;//        IT.Labor.LaborCostBuilding

        $labor_TotalBuilding = $Labor_LaborNormBuilding * $Labor_LaborCostBuilding*$len_fac;
        $capex_it_sep += $labor_TotalBuilding;

        //Нормы трудозатрат специалистов по смежным работам
        $Labor_LaborNormAdd = 0;//        IT.Labor.LaborNormAdd
        $Labor_LaborCostAdd = 0;//        IT.Labor.LaborCostAdd

        $labor_TotalAdd = $Labor_LaborNormAdd * $Labor_LaborCostAdd*$len_fac;
        $capex_it_sep += $labor_TotalAdd;

        //Оплата труда работников социальной сферы
        $Labor_NumberSocialWorkers = 0;//        IT.Labor.NumberSocialWorkers
        $Labor_LaborCostSocial = 0;//        IT.Labor.LaborCostSocial
        $Labor_LaborNormsSocial = 0;//        IT.Labor.LaborNormsSocial

        $labor_TotalSocial = $Labor_NumberSocialWorkers * $Labor_LaborCostSocial * $Labor_LaborNormsSocial;
        $capex_it_sep += $labor_TotalSocial;


        //IT - GENERAL GROUP
        //Отчисления в социальные фонды, страхование
        $General_SocialFunds = 0;//        IT.General.SocialFunds

        $all_direct_costs = $capex_it_sep;

        $capex_it_sep += ($all_direct_costs * ($General_SocialFunds/100));

        //Накладные расходы, включая расходы на администрирование проекта
        $General_Overhead = 0;//        IT.General.Overhead

        $capex_it_sep += ($all_direct_costs * ($General_Overhead/100));

        //НДС
        $General_VAT = 0;//        IT.General.VAT
        $capex_it_sep += ($capex_it_sep * ($General_VAT/100));

        /*----------------------------------------------------------------------------*/

        //В эту переменную будет сложен CAPEX для объектов совместного развёртівания  дороги, ЖД, электричества с ИКТ
        //Рассчитывается с использованием подкласса подкласса Road+IT. или Railway+IT. или Electricity+IT. или Other+IT. в зависимости от типа
        $capex_road_it_codep = 0;


        //Road+IT, Railway+IT, Electricity+IT, Other+IT  - DESIGN GROUP
        //TODO Тут и далее в ключах (названии) переменных вместо Road+IT должно использоваться значение переменной $codepgroupname - определённой выше
        //Затраты на оплату разработки проектной документации
        $Design_LaborNormDesign  = 0;//        Road+IT.Design.LaborNormDesign
        $Design_LaborCostDesign = 0; //        Road+IT.Design.LaborCostDesign
        $Design_NumberOfDesigners = 0;//        Road+IT.Design.NumberOfDesigners

        $design_TotalLaborCostDesign = $Design_LaborNormDesign * $Design_LaborCostDesign * $Design_NumberOfDesigners;
        $capex_road_it_codep += $design_TotalLaborCostDesign;

        //Затраты на разработку сметы строительства
        $Design_LaborNormEstimate = 0; //        Road+IT.Design.LaborNormEstimate
        $Design_LaborCostEstimate = 0;//        Road+IT.Design.LaborCostEstimate
        $Design_NumberOfEstimators = 0; //        Road+IT.Design.NumberOfEstimators

        $design_TotalLaborCostEstimate = $Design_LaborNormEstimate * $Design_LaborCostEstimate * $Design_NumberOfEstimators;
        $capex_road_it_codep += $design_TotalLaborCostEstimate;

        //Затраты на разработку бизнес-плана (при необходимости, на основании проекта и сметы)

        $Design_LaborNormBP = 0;//        Road+IT.Design.LaborNormBP
        $Design_LaborCostBP = 0;//        Road+IT.Design.LaborCostBP
        $Design_NumberOfPlanners = 0;//        Road+IT.Design.NumberOfPlanners

        $design_TotalLaborCostBP = $Design_LaborNormBP * $Design_LaborCostBP * $Design_NumberOfPlanners;
        $capex_road_it_codep += $design_TotalLaborCostBP;

        // Затраты на оплату труда ІТ специалиста

        $Design_LaborNormIT = 0;//        Road+IT.Design.LaborNormIT
        $Design_LaborCostIT = 0;//        Road+IT.Design.LaborCostIT
        $Design_NumberITStaff = 0;//        Road+IT.Design.NumberITStaff

        $design_TotalLaborCostIT = $Design_LaborNormIT*$Design_LaborCostIT*$Design_NumberITStaff;
        $capex_road_it_codep += $design_TotalLaborCostIT;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - PERMITS GROUP
        //Затраты на подготовку пакета документов
        $Permits_LaborNormPack = 0;//        Road+IT.Permits.LaborNormPack
        $Permits_LaborCostPack = 0;//        Road+IT.Permits.LaborCostPack
        $Permits_NumberPackers = 0;//        Road+IT.Permits.NumberPackers

        $permits_TotalLaborCostPack = $Permits_LaborNormPack * $Permits_LaborCostPack * $Permits_NumberPackers;
        $capex_road_it_codep += $permits_TotalLaborCostPack;

        //Затраты на юридическое сопровождение
        $Permits_LaborNormLegal = 0;//        Road+IT.Permits.LaborNormLegal
        $Permits_LaborCostLegal = 0;//        Road+IT.Permits.LaborCostLegal
        $Permits_NumberLegals = 0;//        Road+IT.Permits.NumberLegals

        $permits_TotalLaborCostLegal = $Permits_LaborNormLegal * $Permits_LaborCostLegal * $Permits_NumberLegals;
        $capex_road_it_codep += $permits_TotalLaborCostLegal;

        //Затраты на уплату налогов, госпошлин, прочих обязательных платежей
        $Permits_Taxes = 0;//        Road+IT.Permits.Taxes

        $capex_road_it_codep += $Permits_Taxes;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - DIRECT GROUP
        //Закупка материалов в соответствии со сметой
        $Direct_Materials = 0;//        Road+IT.Direct.Materials

        $capex_road_it_codep += $Direct_Materials*$len_fac;

        //Создание резерва материалов (при необходимости)
        $Direct_Reserve = ($Direct_Materials * ($Direct_Reserve/100));//        Road+IT.Direct.Reserve

        $capex_road_it_codep += $Direct_Reserve;

        //Приобретение машин и оборудования
        $Direct_Equipment = 0;//        Road+IT.Direct.Equipment

        $capex_road_it_codep += $Direct_Equipment*$len_fac;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - Indirect GROUP
        //Затраты на доставку (один или несколько вариантов)
        //Аренда транспорта
        $Indirect_NumberTransport = 0;//        Road+IT.Indirect.NumberTransport
        $Indirect_CostTransportHour = 0;//        Road+IT.Indirect.CostTransportHour
        $Indirect_NumberTransportHours = 0;//        Road+IT.Indirect.NumberTransportHours

        $indirect_TotalTransport = $Indirect_NumberTransport * $Indirect_CostTransportHour * $Indirect_NumberTransportHours;
        $capex_road_it_codep += $indirect_TotalTransport;

        //Оплата доставки материалов
        $Indirect_NumberDeliveres = 0;//        Road+IT.Indirect.NumberDeliveres
        $Indirect_CostDelivery = 0;//        Road+IT.Indirect.CostDelivery

        $indirect_TotalDeliveres = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_road_it_codep += $indirect_TotalDeliveres;

        //ГСМ для собственного транспорта
        $Indirect_CostFuel = 0;//        Road+IT.Indirect.CostFuel
        $Indirect_Mileage = 0;//        Road+IT.Indirect.Mileage

        $indirect_TotalFuel = $Indirect_NumberDeliveres * $Indirect_CostDelivery;
        $capex_road_it_codep += $indirect_TotalFuel;

        //Road+IT, Railway+IT, Electricity+IT, Other+IT - LABOR GROUP
        //Нормы трудозатрат бригады подготовительных работ из расчёта на 1 км
        $Labor_LaborNormPreparation = 0;//        Road+IT.Labor.LaborNormPreparation
        $Labor_LaborCostPreparation = 0;//        Road+IT.Labor.LaborCostPreparation

        $labor_TotalPreparation = $Labor_LaborNormPreparation * $Labor_LaborCostPreparation*$len_fac;
        $capex_road_it_codep += $labor_TotalPreparation;

        //Нормы трудозатрат специалистов по дорожному строительству
        $Labor_LaborNormBuilding = 0;//        Road+IT.Labor.LaborNormBuilding
        $Labor_LaborCostBuilding = 0;//        Road+IT.Labor.LaborCostBuilding

        $labor_TotalBuilding = $Labor_LaborNormBuilding * $Labor_LaborCostBuilding*$len_fac;
        $capex_road_it_codep += $labor_TotalBuilding;

        //Нормы трудозатрат специалистов по смежным работам
        $Labor_LaborNormAdd = 0;//        Road+IT.Labor.LaborNormAdd
        $Labor_LaborCostAdd = 0;//        Road+IT.Labor.LaborCostAdd

        $labor_TotalAdd = $Labor_LaborNormAdd * $Labor_LaborCostAdd*$len_fac;
        $capex_road_it_codep += $labor_TotalAdd;

        //Оплата труда работников социальной сферы
        $Labor_NumberSocialWorkers = 0;//        Road+IT.Labor.NumberSocialWorkers
        $Labor_LaborCostSocial = 0;//        Road+IT.Labor.LaborCostSocial
        $Labor_LaborNormsSocial = 0;//        Road+IT.Labor.LaborNormsSocial

        $labor_TotalSocial = $Labor_NumberSocialWorkers * $Labor_LaborCostSocial * $Labor_LaborNormsSocial;
        $capex_road_it_codep += $labor_TotalSocial;


        //Road+IT, Railway+IT, Electricity+IT, Other+IT - GENERAL GROUP
        //Отчисления в социальные фонды, страхование
        $General_SocialFunds = 0;//        Road+IT.General.SocialFunds

        $all_direct_costs = $capex_road_it_codep;

        $capex_road_it_codep += ($all_direct_costs * ($General_SocialFunds/100));

        //Накладные расходы, включая расходы на администрирование проекта
        $General_Overhead = 0;//        Road+IT.General.Overhead

        $capex_road_it_codep += ($all_direct_costs * ($General_Overhead/100));

        //НДС
        $General_VAT = 0;//        Road+IT.General.VAT
        $capex_road_it_codep += ($capex_road_it_codep * ($General_VAT/100));


        /*----------------------------------------------------------------------------*/

        if ($capex_road_it_codep > 0)
        {
            $economic_efficiency =    (($capex_road_sep + $capex_it_sep)/$capex_road_it_codep*100 - 100);
        }


        return $economic_efficiency; // тут будет число полученное после расчётов
    }
}
