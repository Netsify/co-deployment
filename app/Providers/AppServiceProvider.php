<?php

namespace App\Providers;

use App\Models\Article;
use App\View\Components\DeleteButtton;
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

        /**
         * Директива если статья отклонена
         */
        Blade::if('articleNotRejected', function (Article $article) {
            return $article->published !== 0;
        });

        /**
         * Директива если статья не удалена
         */
        Blade::if('articleNotDeleted', function (Article $article) {
            return is_null($article->deleted_at);
        });

        /**
         * Директива является ли пользователь админом
         */
        Blade::if('admin', function () {
            return auth()->user()->isAdmin();
        });

        Blade::component(DeleteButtton::class, 'delete-button');
    }
}
