<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.articles.unchecked');

        /*$uncheckedArticles = Article::unchecked()->orderByDesc('created_at')->get();
        dump($uncheckedArticles);
        return view('admin.index', compact('uncheckedArticles'));*/
    }
}
