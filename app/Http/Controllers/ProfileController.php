<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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
        $roles = Role::selection()->get();

        return view('profile.edit', ['user' => $profile, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $profile
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request, User $profile)
    {
        $request->file('photo_path')->store('photo', 'public');

        $profile->save($request->validated());

        return back();
    }
}
