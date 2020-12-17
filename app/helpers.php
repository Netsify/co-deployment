<?php
/**
 * Возвращает текущий url но с другой локализацией
 *
 * @return string
 */
function currentRoute() {
    $url = url()->current();
    $url = trim(str_replace(env('APP_URL'), '', $url), '/');
    $segments = explode('/', $url);

    if (in_array($segments[0], config('app.locales'))) {
        $lang = $segments[0];
        unset($segments[0]);
    } else {
        $lang = null;
    }

    switch (app()->getLocale()) {
        case 'ru': $locale = 'en/'; break;
        case 'en': $locale = '/'; break;
    }

    /*$locale = match(app()->getLocale()) {
        'ru' => 'en/',
        'en' => "/"
    };*/
    $url = $locale . implode('/', $segments);

    return $url;
};

/**
 * Получаем нужную локализацию
 *
 * @return null|string
 */
function getLocale(){
    $uri = request()->path();//получаем URI

    $segmentsURI = explode('/',$uri); //делим на части по разделителю "/"

    //Проверяем метку языка  - есть ли она среди доступных языков
    if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], config('app.locales'))) {

        if ($segmentsURI[0] != config('app.locale')) return $segmentsURI[0];

    }

    return null;
}
