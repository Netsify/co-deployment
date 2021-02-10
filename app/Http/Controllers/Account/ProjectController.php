<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Facilities\Proposal;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        $projects = Project::with('status')
            ->whereHas('users', fn($q) => $q->where('users.id', Auth::user()->id))
            ->get();

        return view('account.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project): RedirectResponse
    {
        try {
            $project->delete();
        } catch (\Exception $e) {
            Session::flash('error', __('account.errors.deleteProject'));

            Log::error("Не удалось удалить проект", [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'proposal' => $project->toArray()
            ]);
        }

        return back();
    }

    /**
     * Поиск проектов
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request) : View
    {
        $categories = Category::orderByTranslation('name')->get();

        $tags = Tag::orderByTranslation('name')->get();

        $vars = compact('categories', 'tags');

        if ($request->hasAny(['content', 'category', 'tag'])) {
            $articles = Article::query();

            if ($request->has('content')) {
                $articles->where(fn($q) => $q
                    ->where('title', 'LIKE', '%' . $request->input('content') . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->input('content') . '%')
                );
            }

            if ($request->has('category')) {
                $articles->whereHas('category',
                    fn($q) => $q->where('categories.id', $request->input('category'))
                );
            }

            if ($request->has('tag')) {
                $articles->whereHas('tags',
                    fn($q) => $q->whereIn('tags.id', $request->input('tag'))
                );
            }

            $vars['articles'] = $articles->get();
        }

        return view('knowledgebase.search', $vars);
    }
}
