<?php

namespace App\Services;


use App\Models\Facilities\Proposal;
use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProposalService
{
    /**
     * Предложение о сотрудничестве
     * @var Proposal
     */
    private $_proposal;

    /**
     *Коллекция объектов
     *
     * @var Collection
     */
    private $_facilities = [];

    /**
     * Прикреплённые файлы
     *
     * @var array
     */
    private $_attachments = [];

    /**
     * ProposalService constructor.
     * @param Proposal $proposal
     */
    public function __construct(Proposal $proposal)
    {
        $this->_proposal = $proposal;
    }

    /**
     * Прикрепляем объекты
     *
     * @param Collection $facilities
     */
    public function attachFacilities(Collection $facilities)
    {
        $this->_facilities = $facilities;
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
     * Сохраняет proposal
     *
     * @return bool
     */
    public function save() : bool
    {
        if (!$this->_proposal->save()) {
            Log::error('Не удалось создать proposal', $this->_proposal->toArray());

            return false;
        }

        if (!$this->_proposal->facilities()->sync($this->_facilities)) {
            Log::error('Не удалось прикрепить facilities к proposal', [
                'proposal'   => $this->_proposal->toArray(),
                'facilities' => $this->_facilities->toArray()
            ]);

            return false;
        }

        if ($this->_attachments) {
            return $this->storeFiles();
        }

        return true;
    }

    /**
     * Сохранение приклеплённых файлов
     *
     * @return bool
     */
    protected function storeFiles() : bool
    {
        $files = [];

        foreach ($this->_attachments as $attachment) {
            $file = new File();
            $file->name = $attachment->getClientOriginalName();
            $file->path = $attachment->store('proposals');

            $files[] = $file;
        }

        if (!$this->_proposal->files()->saveMany($files)) {
            Log::error("Не удалось прикрепить файлы к proposal", [
                'proposal'    => $this->_proposal->toArray(),
                'attachments' => $files
            ]);

            return false;
        }

        return true;
    }
}