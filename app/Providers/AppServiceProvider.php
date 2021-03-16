<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Facilities\Facility;
use App\View\Components\DeleteButtton;
use App\View\Components\InvalidFeedback;
use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
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
        if(env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(env('REDIRECT_HTTPS')) {
            $url->formatScheme('https');
        }

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

        /**
         * Директива есть ли у статьи неудаленные файлы
         */
        Blade::if('articleFilesNotDeleted', function (Article $article) {
            return $article->files->isNotEmpty();
        });

        /**
         * Директива есть ли у комментария неудаленные файлы
         */
        Blade::if('commentFilesNotDeleted', function (Comment $comment) {
            return $comment->files->isNotEmpty();
        });

        /**
         * Директива есть ли у объекта неудаленные файлы
         */
        Blade::if('facilityFilesNotDeleted', function (Facility $facility) {
            return $facility->files->isNotEmpty();
        });

        Blade::if('proposalUnderConsideration', function (Proposal $proposal) {
            return $proposal->status_id === ProposalStatus::UNDER_CONSIDERATION;
        });

        Paginator::useBootstrap();
    }
}
