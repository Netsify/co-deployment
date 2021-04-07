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
        $user = Auth::user();

        $user->fill($request->validated());

        if ($request->has('photo')) {
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

        if ($user->save()) {
            session()->flash('message', __('dictionary.ProfileSaved'));
        } else {
            session()->flash('message', __('dictionary.ProfileNotSaved'));

            Log::error('Не удалось обновить профиль', compact('user'));
        }

        return back();
    }
}
