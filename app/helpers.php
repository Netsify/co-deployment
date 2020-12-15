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
}
