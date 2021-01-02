<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $publishedArticles = Article::query()->where('published', 1)->orderByDesc('created_at')->get();

        $deletedArticles = Article::onlyTrashed()->orWhere('published', 0)->get();

        dump($publishedArticles, $deletedArticles);

        return view('admin.index');
    }
}
