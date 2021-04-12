<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Может ли текущий пользователь удалить фото профайла другого пользователя
     *
     * @param User $user
     * @return bool
     */
    public function deletePhoto(User $user): bool
    {
        return Auth::user() == $user;
    }
}
