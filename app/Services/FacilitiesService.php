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

    public static function getCompatibilityRating(Facility $facility, $objects)
    {
        $facility->load('compatibilityParams.translations');
        $f_params = $facility->compatibilityParams->toArray();
        $array = [];
        $objects->load('compatibilityParams.translations');
        if ($objects instanceof Collection) {
            foreach ($objects as $object) {
                dump(1);
                /*$obj_params = $object->compatibilityParams->toArray();
//                dump($obj_params);

                foreach ($f_params as $param) {
                    $group = $param['group_id'];
                    $param_id = $param['pivot']['compatibility_param_id'];
                    $array[$group][$param_id][] = $param;
                }

                foreach ($obj_params as $param) {
                    $group = $param['group_id'];
                    $param_id = $param['pivot']['compatibility_param_id'];
                    $array[$group][$param_id][] = $param;
                }*/

//                echo "<hr>";
            }
        }
        dump($array);
    }
}