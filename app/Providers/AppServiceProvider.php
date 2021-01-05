<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Директива если статья не опубликована
         */
        Blade::if('articleNotPublished', function (Article $article) {
            return $article->published !== 1;
        });

        Blade::if('articleNotRejected', function (Article $article) {
            return $article->published !== 0;
        });
    }
}
