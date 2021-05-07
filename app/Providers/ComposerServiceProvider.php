<?php

namespace App\Providers;

use App\View\Composers\CategoryComposer;
use App\Storage\UIStore;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('knowledgebase.categories.sidebar', CategoryComposer::class);

        View::composer('layouts.navbar',  fn($view) => $view->with([
            'unescap_logo' => asset(UIStore::UNESCAP_LOGO)
        ]));

        View::composer('layouts.footer', fn($view) => $view->with([
            'title' => __('footer.main', ['year' => now()->year]),
            'logo' => asset(UIStore::UNESCAP_LOGO_WHITE)
        ]));
    }
}
