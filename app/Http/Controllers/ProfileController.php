<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Контроллер профиля пользователя
 *
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $profile
     * @return View
     */
    public function edit(User $profile) : View
    {
        $roles = $profile->isAdmin()
            ? Role::orderByTranslation('id')->get()
            : Role::orderByTranslation('id')->get()->except(Role::ROLE_ADMIN_ID);

        return view('profile.edit', ['user' => $profile, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $profile
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request, User $profile) : RedirectResponse
    {
        $profile->fill($request->validated());

        if ($request->has('photo')) {
            $profile->photo_path = $request->file('photo')->store('profiles', 'public');
        }

        if ($request->filled('phone')) {
            $profile->phone = $request->input('phone');
        }

        if ($request->filled('password')) {
            $profile->password = Hash::make($request->input('password'));
        }

        if ($request->filled('organization')) {
            $profile->organization = $request->input('organization');
        }

        if ($request->filled('summary')) {
            $profile->summary = $request->input('summary');
        }

        if ($profile->save()) {
            session()->flash('message', __('dictionary.ProfileSaved'));
        } else {
            session()->flash('message', __('dictionary.ProfileNotSaved'));
            Log::error('Не удалось обновить профиль', compact('profile'));
        }

        return back();
    }
}
