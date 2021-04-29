<?php

namespace App\Providers;

use App\Models\Category;
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
        $categories = Category::query()
            ->withCount(['childrenArticles' => fn($q) => $q->published()])
            ->with(['articles' => fn($q) => $q->published(),
                    'translations',
                    'children.translations',
                    'children.articles' => fn($q) => $q->published()])
            ->whereNull('parent_id')
            ->get();

        foreach ($categories as $category) {
            $category->articles_sum = $category->articles->count() + $category->children_articles_count;

            foreach ($category->children as $child) {
                $child->articles_count = $child->articles->count();
            }
        }

        View::composer('knowledgebase.categories.sidebar', fn($view) => $view->with(['categories' => $categories]));

        View::composer('layouts.navbar',  fn($view) => $view->with([
            'unescap_logo' => asset(UIStore::UNESCAP_LOGO)
        ]));
    }
}
