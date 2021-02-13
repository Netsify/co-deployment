<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return View
     */
    public function edit(Project $project): View
    {
        $project->with('users', 'status', 'facilities');

        $statuses = ProjectStatus::all();

        return view('account.projects.edit', compact('project', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->fill($request->validated());

        if ($project->save()) {
            Session::flash('message', __('account.project_updated'));
        } else {
            Session::flash('message', __('account.errors.project_not_updated'));

            Log::error('Не удалось обновить проект', compact($project));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return RedirectResponse
     */
//    public function destroy(Project $project): RedirectResponse
//    {
//        try {
//            $project->delete();
//        } catch (\Exception $e) {
//            Session::flash('error', __('account.errors.deleteProject'));
//
//            Log::error("Не удалось удалить проект", [
//                'message'  => $e->getMessage(),
//                'code'     => $e->getCode(),
//                'trace'    => $e->getTrace(),
//                'proposal' => $project->toArray()
//            ]);
//        }
//
//        return back();
//    }

    /**
     * Добавляет файлы к комментарию проекта
     *
     * @param CommentRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function addComment(CommentRequest $request, Project $project): RedirectResponse
    {
        $params = $request->validated() + ['user_id' => Auth::user()->id];

        $comment = $project->comments()->create($params);

        if ($comment) {
            Session::flash('message', __('comment.comment_stored'));

            $files = $request->file('files');

            if (!is_null($files)) {
                if (!$this->attachFilesToComment($comment, $files)) {

                    Log::error('Не удалось прикрепить файлы к комментарию проекта', [
                        'comment' => $comment,
                        'files' => $files
                    ]);
                }
            }
        } else {
            Session::flash('message', __('comment.errors.comment_not_stored'));

            Log::error('Не удалось создать комментарий', $params);
        }

        return back();
    }

    /**
     * Прикрепляет файлы к комментарию проекта
     *
     * @param Comment $comment
     * @param array $files
     * @return bool
     */
    private function attachFilesToComment(Comment $comment, array $files): bool
    {
        foreach ($files as $file) {
            $storedPath = $file->store('comments', 'public');

            $comment->files()->create([
                'path' => $storedPath,
                'name' => $file->getClientOriginalName(),
            ]);
        }

        return true;
    }

    /**
     * Удалить файл у комментария проекта
     *
     * @param Comment $comment
     * @param File $file
     * @return RedirectResponse
     */
    public function deleteFileFromComment(Project $project, Comment $comment, File $file): RedirectResponse
    {
        //доработать при включении не работает File::class => ArticlePolicy::class
//        if (Gate::denies('deleteFileFromComment', [$file, $comment])) {
//            abort(403);
//        }

        try {
            if (!$file->delete()) {
                Session::flash('error', __('account.errors.delete_file'));

                Log::error("Не удалось удалить файл у комментария проекта", compact('file'));
            }
        } catch (\Exception $e) {
            Session::flash('error', __('account.errors.delete_file'));

            Log::error("Не удалось удалить файл у комментария проекта", [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTrace(),
                'file'    => $file
            ]);
        }

        return back();
    }
}
