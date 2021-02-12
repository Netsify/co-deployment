<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Facilities\Proposal;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Отображение и поиск проектов
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request) : View
    {
        $statuses = ProjectStatus::all();

        $projects = Project::query();

        $projects->with('status', 'comments')
            ->whereHas('users', fn($q) => $q->where('users.id', Auth::user()->id));

        if ($request->filled('content')) {
            $projects->where(fn($q) => $q
                ->where('title', 'LIKE', '%' . $request->input('content') . '%')
                ->orWhere('description', 'LIKE', '%' . $request->input('content') . '%')
            );
        }

        if ($request->filled('status')) {
            $projects->whereHas('status',
                fn($q) => $q->where('project_statuses.id', $request->input('status')));
        }

        if ($request->filled('date_from')) {
            $projects->where('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $projects->where('created_at', '<=', $request->input('date_to'));
        }

        $projects = $projects->oldest()->get();

        return view('account.projects.index', compact('projects', 'statuses'));
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
     * Сохранение комментария к проекту
     *
     * @param CommentRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function store(CommentRequest $request): RedirectResponse
    {
//        $comment = $project->comments()->create($request->validated());

//        $project->comments()->sync($comment, false);

        return back();
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
     * @param Project $project
     * @return View
     */
    public function edit(Project $project) : View
    {
        $project->with('users', 'status', 'facilities');

        $statuses = ProjectStatus::all();

        return view('account.projects.edit', compact('project', 'statuses'));
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
}
