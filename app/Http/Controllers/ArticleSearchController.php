<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ArticleSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        $categories = Category::query()->orderByTranslation('name')->get();

        $tags = Tag::query()->orderByTranslation('name')->get();

        return view('knowledgebase.search', compact('categories', 'tags'));
    }
}
