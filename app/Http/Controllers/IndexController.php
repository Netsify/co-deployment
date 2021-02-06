<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Главная страница сайта
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        /*$articles = Article::published()
            ->with(['category.translations', 'user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('index', compact('articles'));*/
        return view('attention');
    }
}
