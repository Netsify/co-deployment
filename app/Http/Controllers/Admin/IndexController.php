<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function articles()
    {
        return redirect()->route('admin.articles.unchecked');
    }

    public function index()
    {
        return view('admin.index');
    }
}
