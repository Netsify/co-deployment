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

Route::group(['prefix' => getLocale()], function () {
    Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('main');

    Auth::routes();
    Route::middleware('auth')->group(function () {
        Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::resource('articles', \App\Http\Controllers\ArticlesController::class)->except(
            ['index', 'show']);

        Route::resource('profile', \App\Http\Controllers\ProfileController::class)
        ->only('index', 'store', 'edit', 'update')->middleware('auth');

        Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

            /**
             * Роуты для работы со статьями базы знаний в админке
             */
            Route::prefix('articles')->name('articles.')->group(function () {
                Route::get('/unchecked', [\App\Http\Controllers\Admin\ArticlesController::class, 'unchecked'])->name('unchecked');

                Route::put('/{article}/publicate', [\App\Http\Controllers\Admin\ArticlesController::class, 'publicate'])->name('publicate');
                Route::put('/{article}/reject', [\App\Http\Controllers\Admin\ArticlesController::class, 'reject'])->name('reject');
            });
        });
    });

    Route::resource('articles', \App\Http\Controllers\ArticlesController::class)->only(['index', 'show']);
});
