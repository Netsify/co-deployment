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
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/test', function () {
        $name = (new \App\Models\Test())->name;
        return view('test', compact('name'));
    });

    Route::get('/test/roles', function () {
/*        $data = [
            'slug' => 'admin',
            'ru' => ['name' => 'Администратор'],
            'en' => ['name' => 'Admin'],
        ];
        $admin = \App\Models\Role::create($data);*/

        $admin = \App\Models\Role::query()->first();
        dd($admin->translate(getLocale())->name);
    });
});
