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
    private $_c_params =[];

    /**
     * Конструктор
     * 
     * FacilitiesService constructor.
     * @param Facility $facility
     */
    public function __construct(Facility $facility, array $c_params)
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
    protected function storeFiles(Facility $facility) : bool 
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

    protected function setCompatibilityParams(Facility $facility)
    {
        foreach ($this->_c_params as $id => $value) {
            if ($facility->compatibilityParams()->attach($id, ['value' => $value])) {
                return false;
            }
        }

        return true;
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
                self::getCompatibilityRatingByParams($f_params, $object);
                $objects[$key] = $object;
            }

    }

    /**
     * Метод задаёт параметр совместимости для объекта с которым сравнивается выбранный объект пользователя
     *
     * @param Collection $my_facility_c_params
     * @param Facility $facility
     */
    public static function getCompatibilityRatingByParams(Collection $my_facility_c_params, Facility &$facility)
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
        $facility->compatibility_level = round($sum / count($array), 2);
    }
}