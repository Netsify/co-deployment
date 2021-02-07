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

Route::get('test', function () {
    return response()->json(['key' => "value"]);
})->name('test')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/facilities/compatibility-params', [\App\Http\Controllers\API\CompatibilityParamsController::class, 'index'])
        ->name('facilities.compatibility_params');
});