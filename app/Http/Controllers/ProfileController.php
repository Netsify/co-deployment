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
use Illuminate\Support\Facades\Storage;

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
     * @return View
     */
    public function edit() : View
    {
        $user = Auth::user();

        $roles = $user->isAdmin()
            ? Role::orderByTranslation('id')->get()
            : Role::orderByTranslation('id')->get()->except(Role::ROLE_ADMIN_ID);

        return view('profile.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProfileRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request) : RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($request->has('photo')) {
            if ($user->photo_path) {
                $this->removePhoto($user);
            }

            $user->photo_path = $request->file('photo')->store('profiles', 'public');
        }

        if ($request->filled('phone')) {
            $user->phone = $request->input('phone');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->filled('organization')) {
            $user->organization = $request->input('organization');
        }

        if ($request->filled('summary')) {
            $user->summary = $request->input('summary');
        }

        $this->save($user);

        return back();
    }

    /**
     * Действия при сохранении пользователя
     *
     * @param User $user
     */
    public function save(User $user)
    {
        if ($user->save() === true) {
            session()->flash('message', __('dictionary.ProfileSaved'));
        } else {
            Log::error('Не удалось обновить профиль', compact('user'));

            session()->flash('message', __('dictionary.ProfileNotSaved'));
        }
    }

    /**
     * Действия при удалении фото пользователя из хранилища
     *
     * @param User $user
     */
    public function removePhoto(User $user)
    {
        if (Storage::delete($user->photo_path) === false) {
            Log::error('Не удалось удалить фото профиля', compact('user'));
        }
    }

    /**
     * Обнуляет фото профиля
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function nullifyPhoto(User $user): RedirectResponse
    {
        if ($user->cannot('deletePhoto', $user)) {
            abort(403);
        }

        $this->removePhoto($user);

        $user->photo_path = null;

        $this->save($user);

        return back();
    }
}
