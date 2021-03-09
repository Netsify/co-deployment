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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('main');

Auth::routes();

Route::get('/facilities/search', [\App\Http\Controllers\FacilitiesSearchController::class, 'search'])
    ->name('facilities.search');

Route::resource('facilities',\App\Http\Controllers\FacilitiesController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {

    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('articles', \App\Http\Controllers\ArticlesController::class)
        ->except(['index', 'show']);

    Route::delete('/articles/{article}/file/{file}/delete', [\App\Http\Controllers\Admin\ArticlesController::class, 'deleteFile'])
        ->name('articles.delete_file');

    Route::resource('profile', \App\Http\Controllers\ProfileController::class)
        ->only('index', 'edit', 'update');

    Route::post('/proposals/send/facility_of_sender/{f_of_sender}/facility_of_receiver/{f_of_receiver}',
        [\App\Http\Controllers\ProposalController::class, 'send'])->name('proposal.send');

    /**
     * Роуты для работы с вкладками личного кабинета (профиль, объекты, проекты, входящие, отправленные предложения)
     */
    Route::prefix('account')->name('account.')->group(function () {

        Route::get('facilities', [\App\Http\Controllers\FacilitiesController::class, 'accountIndex'])
            ->name('facilities.index');

        Route::delete('/facilities/{facility}/file/{file}/delete',
            [\App\Http\Controllers\FacilitiesController::class, 'deleteFile'])->name('facilities.delete_file');

        Route::resource('facilities', \App\Http\Controllers\FacilitiesController::class)
            ->except('index', 'show');

        Route::resource('projects',\App\Http\Controllers\Account\ProjectController::class);

        Route::post('projects/{project}/add_comment',
            [\App\Http\Controllers\Account\ProjectController::class, 'addComment'])
            ->name('projects.add_comment');

        Route::delete('/projects/{project}/comment/{comment}/file/{file}/delete',
            [\App\Http\Controllers\Account\ProjectController::class, 'deleteFileFromComment'])
            ->name('projects.delete_file');

        Route::resource('inbox', \App\Http\Controllers\Account\InboxController::class);

        Route::post('/inbox/proposal/{proposal}/decline', [\App\Http\Controllers\ProposalController::class, 'decline'])
            ->name('proposal.decline');

        Route::post('/inbox/proposal/{proposal}/accept', [\App\Http\Controllers\ProposalController::class, 'accept'])
            ->name('proposal.accept');

        Route::resource('inbox', \App\Http\Controllers\Account\InboxController::class)
            ->except('destroy');

        Route::delete('inbox/{proposal}', [\App\Http\Controllers\Account\InboxController::class, 'destroy'])
            ->name('inbox.delete');

        Route::resource('sent-proposals', \App\Http\Controllers\Account\SentProposalController::class)
            ->except('destroy');

        Route::delete('sent-proposals/{proposal}', [\App\Http\Controllers\Account\SentProposalController::class, 'destroy'])
            ->name('sent-proposals.delete');

        Route::get('/variables', [\App\Http\Controllers\Account\VariablesController::class, 'index'])
            ->name('variables.index');

        Route::get('/variables/group/{group}', [\App\Http\Controllers\Account\VariablesController::class, 'list'])
            ->name('variables.list');

        Route::post('/variables/group/{group}', [\App\Http\Controllers\Account\VariablesController::class, 'storeForUser'])
            ->name('variables.store');
    });

    /**
     * Роуты для работы с админкой
     */
    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        /**
         * Роуты для работы со статьями базы знаний в админке
         */
        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'articles'])->name('index');

            Route::resource('categories', \App\Http\Controllers\CategoryController::class);

            Route::get('/unchecked', [\App\Http\Controllers\Admin\ArticlesController::class, 'unchecked'])->name('unchecked');
            Route::get('/published', [\App\Http\Controllers\Admin\ArticlesController::class, 'published'])->name('published');
            Route::get('/rejcected_and_deleted', [\App\Http\Controllers\Admin\ArticlesController::class, 'rejectedAndDeleted'])->name('rejected_deleted');

            Route::get('/article/{article_with_trashed}', [\App\Http\Controllers\Admin\ArticlesController::class, 'show'])->name('show');
            Route::get('/article/{article_with_trashed}/edit', [\App\Http\Controllers\Admin\ArticlesController::class, 'edit'])->name('edit');

            Route::put('/{article_with_trashed}/verify', [\App\Http\Controllers\Admin\ArticlesController::class, 'verify'])->name('verify');

            Route::delete('{article}/delete', [\App\Http\Controllers\Admin\ArticlesController::class, 'destroy'])->name('destroy');
        });

        /**
         * Роуты для работы с объектами инфраструктуры
         */
        Route::prefix('facilities')->name('facilities.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\FacilitiesController::class, 'index'])->name('index');

            /**
             * Роуты для работы с параметрами соместимости объектов
             */
            Route::resource('compatibility_params', \App\Http\Controllers\Admin\CompatibilityParamsController::class);

            /**
             * Роуты для работы с переменными для экономической эффективности объектов (кроме show)
             */
            Route::resource('variables', \App\Http\Controllers\Admin\VariablesController::class)->except('show');
        });
    });
});

Route::get('/articles/search', [\App\Http\Controllers\ArticlesController::class, 'search'])
    ->name('articles.search');

Route::resource('articles',\App\Http\Controllers\ArticlesController::class)->only('index', 'show');

Route::get('articles/category/{category}', [\App\Http\Controllers\ArticlesController::class, 'index'])
    ->name('articles.index');
