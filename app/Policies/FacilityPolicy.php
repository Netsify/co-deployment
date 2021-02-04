<?php

namespace App\Policies;

use App\Models\Facilities\Facility;
use App\Models\Facilities\FacilityVisibility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facilities\Facility  $facility
     * @return mixed
     */
    public function view(User $user, Facility $facility)
    {
        return $facility->user_id === $user->id || $facility->visibility->slug !== FacilityVisibility::ONLY_FOR_ME;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role->slug, [Role::ROLE_ROADS_OWNER, Role::ROLE_ICT_OWNER]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facilities\Facility  $facility
     * @return mixed
     */
    public function update(User $user, Facility $facility)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facilities\Facility  $facility
     * @return mixed
     */
    public function delete(User $user, Facility $facility)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facilities\Facility  $facility
     * @return mixed
     */
    public function restore(User $user, Facility $facility)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facilities\Facility  $facility
     * @return mixed
     */
    public function forceDelete(User $user, Facility $facility)
    {
        //
    }
}
