<?php


use Localization;
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

//Route::middleware('setlocale')->prefix('{lang?}')->group(function () {
Route::middleware('setlocale')->prefix(Localization::locale())->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('root');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/test', function () {
        return (new \App\Models\Test())->name;
    });

    /*Route::get('set-lang/{lang}', function () {
        return redirect()->ba*ck();
    })->name('set-locale');*/
});
