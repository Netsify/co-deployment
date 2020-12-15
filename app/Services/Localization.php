<?php
/**
 * Created by PhpStorm.
 * User: isaev
 * Date: 13.12.20
 * Time: 18:12
 */

namespace App\Services;

/**
 * Сервис для работы с локализацией сайта
 *
 * Class Localization
 * @package App\Services
 */
class Localization
{
    public function locale()
    {
        $locale = request()->segment(1, '');

        if ($locale && in_array($locale, config('app.locales'))) {
            return $locale;
        }

        return '';
    }
}