<?php

namespace App\Repositories;

use App\Models\Category;

/**
 * Репозиторий категорий в сайдбаре
 *
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{
    /**
     * Объект категории
     *
     * @var Category
     */
    protected Category $category;

    /**
     * Объект контроллера
     *
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Получаем категории сайдбара
     *
     * @return mixed
     */
    public function getCategories(): mixed
    {
        $categories = $this->category->query()
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

        return $categories;
    }
}
