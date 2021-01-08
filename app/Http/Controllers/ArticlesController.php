<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\KnowledgeBaseService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Контроллер
 *
 * Class ArticlesController
 * @package App\Http\Controllers
 */
class ArticlesController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::published()
            ->with(['category.translations', 'tags.translations', 'user'])
            ->orderByDesc('created_at')
            ->get();

        return view('knowledgebase.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::query()->orderByTranslation('name')->get();
        $tags = Tag::query()->orderByTranslation('name')->get();

        return view('knowledgebase.form', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $article = new Article($request->only(['title', 'content']));
        $article->category_id = $request->get('category');

        $knowledgeBaseService = new KnowledgeBaseService($article, Auth::user());
        if ($knowledgeBaseService->createArticle($request->get('tag'), $request->file('files'))) {
            return redirect()->route('home');
        }

        Session::flash('error','При создании статьи возникли проблемы. Пожалуйста попробуйте позже.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, $fromAdminPanel = false)
    {
        $article->load('tags.translations');

        return view('knowledgebase.show', compact('article', 'fromAdminPanel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if (Auth::user()->cannot('update', $article)) {
            abort(403);
        }

        $categories = Category::query()->orderByTranslation('name')->get();
        $tags = Tag::query()->orderByTranslation('name')->get();

        return view('knowledgebase.form', compact('categories', 'tags', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        if (Auth::user()->cannot('update', $article)) {
            abort(403);
        }

        $article->title       = $request->get('title');
        $article->category_id = $request->get('category');
        $article->content     = $request->get('content');

        $knowledgeBaseService = new KnowledgeBaseService($article, Auth::user());
        if ($knowledgeBaseService->updateArticle($request->get('tag'))) {
            return redirect()->route('home');
        }

        Session::flash('error', __('knowledgebase.errors.update'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @param bool $routeBack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article, $routeBack = false)
    {
        try {
            if (!$article->delete()) {
                Session::flash('error', __('knowledgebase.errors.delete'));

                Log::error("Не удалось удалить статью", ['article' => $article->toArray()]);
            }
        } catch (\Exception $e) {
            Session::flash('error', __('knowledgebase.errors.delete'));

            Log::error("Не удалось удалить статью", [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTrace(),
                'article' => $article->toArray()
            ]);

            return redirect()->back();
        }

        if ($routeBack) {
            return redirect()->back();
        }

        return redirect()->route('articles.index');
    }
}
