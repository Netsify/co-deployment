<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Test extends Model
{
    use HasFactory;

    public $name_ru = 'Русский';
    public $name_en = 'English';

    public function getNameAttribute()
    {
        $locale = App::getLocale();

        switch ($locale) {
            case 'ru': return $this->name_ru;
            case 'en': return $this->name_en;
        }
    }
}
