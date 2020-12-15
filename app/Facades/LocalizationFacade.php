<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад для работы с локализацией сайта
 *
 * Class LocalizationFacade
 * @package App\Facades
 */
class LocalizationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "Localization";
    }
}