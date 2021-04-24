<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Storage\UIStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    /**
     * Главная страница сайта
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $ict_image = Storage::url(UIStore::ICT_START_PAGE_IMAGE);
        $road_image = Storage::url(UIStore::ROAD_START_PAGE_IMAGE);
        $background = Storage::url(UIStore::BACKGROUND_GREY);

        return view('index', compact('ict_image', 'road_image', 'background'));
    }
}
