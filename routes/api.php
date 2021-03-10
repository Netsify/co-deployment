<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('test', function () {
    return response()->json(['key' => "value"]);
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ref-book/facility_type/{facility_type}/descriptions',
        [\App\Http\Controllers\API\ReferenceBookController::class, 'getDescriptions']);

    Route::get('/variables/list', [\App\Http\Controllers\API\VariablesController::class, 'getByGroup']);

    Route::post('/variables/store_for_user', [\App\Http\Controllers\API\VariablesController::class, 'storeForUser']);

    Route::put('/users/{user}',[ \App\Http\Controllers\Admin\UserController::class, 'verify'])
        ->name('admin.users.verify');
});
