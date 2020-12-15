<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::middleware('setlocale')->prefix(Localization::locale())->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('root');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/test', function () {
        $name = (new \App\Models\Test())->name;
        return view('test', compact('name'));
    });

});*/

Route::group(['prefix' => \App\Http\Middleware\SetLocale::getLocale()], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();


    Route::get('/test', function () {
//        dd(\App\Http\Middleware\SetLocale::getLocale());
        $name = (new \App\Models\Test())->name;
        return view('test', compact('name'));
    });
});
