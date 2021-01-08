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
            ->only('index', 'edit', 'update');

        Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

            /**
             * Роуты для работы со статьями базы знаний в админке
             */
            Route::prefix('articles')->name('articles.')->group(function () {
                Route::get('/unchecked', [\App\Http\Controllers\Admin\ArticlesController::class, 'unchecked'])->name('unchecked');
                Route::get('/published', [\App\Http\Controllers\Admin\ArticlesController::class, 'published'])->name('published');
                Route::get('/rejcected_and_deleted', [\App\Http\Controllers\Admin\ArticlesController::class, 'rejectedAndDeleted'])->name('rejected_deleted');

                Route::get('/article/{article_with_trashed}', [\App\Http\Controllers\Admin\ArticlesController::class, 'show'])->name('show');
                Route::get('/article/{article_with_trashed}/edit', [\App\Http\Controllers\Admin\ArticlesController::class, 'edit'])->name('edit');

                Route::put('/{article_with_trashed}/verify', [\App\Http\Controllers\Admin\ArticlesController::class, 'verify'])->name('verify');

                Route::delete('{article}/delete', [\App\Http\Controllers\Admin\ArticlesController::class, 'destroy'])->name('destroy');
            });
        });
    });

    Route::resource('articles', \App\Http\Controllers\ArticlesController::class)->only(['index', 'show']);
});
