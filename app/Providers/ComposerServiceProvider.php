<?php

namespace App\Providers;

use App\Models\Category;
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
        $categories = Category::withCount('childArticles')
            ->with(['articles' => fn($q) => $q->published(),
                    'translations',
                    'children.translations',
                    'children.articles' => fn($q) => $q->published()])
            ->whereNull('parent_id')
            ->get();

        View::composer('knowledgebase.categories.sidebar', fn($view) => $view->with(['categories' => $categories]));
    }
}
