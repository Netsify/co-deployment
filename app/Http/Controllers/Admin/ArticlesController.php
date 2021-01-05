<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * Контроллер для работы со статьями в админке
 *
 * Class ArticlesController
 * @package App\Http\Controllers\Admin
 */
class ArticlesController extends Controller
{
    /**
     * Непроверенные статьи
     *
     * @return View
     */
    public function unchecked() : View
    {
        $articles = Article::unchecked()->orderByDesc('created_at')->get();
        $title = __('knowledgebase.unchecked_articles');

        return view('admin.articles.index', compact('articles', 'title'));
    }

    public function publicate(Article $article)
    {
        try {
            $article->checked_by_admin = true;
            $article->published = true;

            if (!$article->save()) {
                Session::flash('error', __('knowledgebase.errors.is_not_publicated'));

                Log::error("Не удалось опубликовать статью", ['article' => $article->toJson()]);
            }
        } catch (\Exception $e) {
            Session::flash('error', __('knowledgebase.errors.is_not_publicated'));

            Log::error("Не удалось опубликовать статью", [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTrace()
            ]);
        } finally {
            return redirect()->back();
        }
    }

    public function reject(Article $article)
    {

    }
}
