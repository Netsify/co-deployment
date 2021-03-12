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

        return 10; // тут будет число полученное после расчётов
    }
}
