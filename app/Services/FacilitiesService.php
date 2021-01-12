<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use App\Models\File;
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
     * Конструктор
     * 
     * FacilitiesService constructor.
     * @param Facility $facility
     */
    public function __construct(Facility $facility)
    {
        $this->_facility = $facility;
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
                'facility'    => $this->_facility->toArray(),
                'attachments' => $files
            ]);

            return false;
        }
    }
}