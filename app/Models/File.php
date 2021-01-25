<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'name',
    ];

    /**
     * Путь до файлов
     *
     * @return string
     */
    public function getLinkAttribute() : string
    {
        return Storage::url($this->path);
    }
  
    public function fileable()
    {
        return $this->morphTo();
    }
}
