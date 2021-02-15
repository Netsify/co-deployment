<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function view(User $user, Project $project): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $project->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function delete(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Является ли пользователь участником проекта
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function createComment(User $user, Project $project): bool
    {
        return $project->users->contains($user);
    }

    /**
     * Содержит ли проект комментарий
     *
     * @param User $user
     * @param Project $project
     * @param Comment $comment
     * @return bool
     */
    public function projectHasComment(User $user, Project $project, Comment $comment): bool
    {
        return $project->comments->contains($comment);
    }

    /**
     * Содержит ли комментарий файл
     *
     * @param User $user
     * @param Comment $comment
     * @param File $file
     * @return bool
     */
    public function commentHasFile(User $user, Project $project, Comment $comment, File $file): bool
    {
//        return $comment->files->contains($file);
        return true;
    }

    /**
     * Может ли пользователь удалить файл из комментария у проекта
     *
     * @param $user
     * @param $project
     * @param $comment
     * @param $file
     * @return bool
     */
    public function deleteCommentFile(User $user, Project $project, Comment $comment, File $file): bool
    {
        if ($this->createComment($user, $project)
            && $this->projectHasComment($user, $project, $comment)
            && $this->commentHasFile($user, $file, $comment)
        )
        {
            return true;
        }
    }
}
