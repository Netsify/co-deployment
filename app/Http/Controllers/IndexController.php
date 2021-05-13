<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Storage\UIStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    /**
     * Главная страница сайта для неавторизованных
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function indexForUnathorized()
    {
        $ict_image = Storage::url(UIStore::ICT_START_PAGE_IMAGE);
        $road_image = Storage::url(UIStore::ROAD_START_PAGE_IMAGE);
        $background = Storage::url(UIStore::BACKGROUND_GREY);

        return view('index', compact('ict_image', 'road_image', 'background'));
    }

    /**
     * Главная страница сайта для админа
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function indexForAdmin()
    {
        return view('admin.index');
    }

    /**
     * Главная для владельца инфраструктуры
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function indexForInfrastructureOwner()
    {
        $toolbar_items = [
            [
                'name' => 'account.profile',
                'link' => 'profile.index',
                'icon' => 'profile'
            ],
            [
                'name' => 'facility.facilities',
                'link' => 'account.facilities.index',
                'icon' => 'facilities'
            ],
            [
                'name' => 'account.projects',
                'link' => 'account.projects.index',
                'icon' => 'projects'
            ],
            [
                'name' => 'account.inbox',
                'link' => 'account.inbox.index',
                'icon' => 'inbox'
            ],
            [
                'name' => 'account.sent_proposals',
                'link' => 'account.sent-proposals.index',
                'icon' => 'sent'
            ],
            [
                'name' => 'account.economic_variables',
                'link' => 'account.variables.index',
                'icon' => 'variables'
            ],
        ];

        return view('infrastructure-owner-index', compact('toolbar_items'));
    }

    /**
     * Главная страница сайта в зависимости от роли пользователя
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (Auth::check()) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            if ($user->isAdmin()) {
                return $this->indexForAdmin();
            }

            if ($user->isRoadOrICT()) {
                return $this->indexForInfrastructureOwner();
            }

            return redirect()->route('profile.index');
        }

        return $this->indexForUnathorized();
    }
}
