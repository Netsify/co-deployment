<?php

namespace App\Providers;

use App\Services\Localization;
use Illuminate\Support\ServiceProvider;

/**
 * Провайдер для работы с локализацией сайта
 *
 * Class LocalizationServiceProvider
 * @package App\Providers
 */
class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Localization', Localization::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
