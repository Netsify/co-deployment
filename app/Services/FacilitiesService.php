<?php

namespace App\Services;
use App\Models\Facilities\Facility;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

/**
 * Сервис для работы с объектами инфраструктуры
 *
 * Class FacilitiesService
 * @package App\Services
 */
class FacilitiesService
{
    private $_facility;
    private $_attachmets = [];

    public function __construct(Facility $facility)
    {
        $facility->setIdentificator('str');
        $facility->setLocale(app()->getLocale());

        $this->_facility = $facility;
    }

    public function attachFiles(array $attachments)
    {
            $this->_attachmets = $attachments;
    }

    public function save()
    {
        $facility = Auth::user()->facilities()->save($this->_facility);

        if ($facility) {
            if (!empty($this->_attachmets)) {
                $files = [];

                foreach ($this->_attachmets as $attachmet) {
                    $file = new File();
                    $file->name = $attachmet->getClientOriginalName();
                    $file->path = $attachmet->store('facilities');

                    $files[] = $file;
                }

                return $facility->files()->saveMany($files);
            }
        }
    }
}