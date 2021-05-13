<?php

namespace App\View\Components;

use App\Models\Article;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $article;

    public $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Article $article, $route)
    {
        $this->article = $article;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.delete-button');
    }
}
