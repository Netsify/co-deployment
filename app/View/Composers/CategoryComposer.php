<?php

namespace App\View\Composers;

use App\Repositories\CategoryRepository;
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Объект репозитория категории
     *
     * @var CategoryRepository
     */
    protected CategoryRepository $categories;

    /**
     * Объект композера
     *
     * CategoryComposer constructor.
     * @param CategoryRepository $categories
     */
    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Передаем категории в представление
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories->getCategories());
    }
}
