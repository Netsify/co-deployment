<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function verify(User $user): JsonResponse
    {
        $user->verified = !$user->verified;

        if ($user->save()) {
            $message = __('dictionary.user_updated');
        } else {
            $message = __('dictionary.errors.user_not_updated');

            Log::error('Не удалось обновить пользователя', compact($user));
        }

        return response()->json(compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            Session::flash('error', __('dictionary.errors.delete_user'));

            Log::error("Не удалось удалить пользователя", [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'facility' => $user->toArray()
            ]);
        }

        return back();
    }
}
