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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('refresh');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'usuario'

], function ($router) {
    Route::get('ListadoUsuario', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth:api');
    Route::post('IngresarUsuario', [App\Http\Controllers\UserController::class, 'store'])->middleware('auth:api');
    Route::put('ActualizarUsuario', [App\Http\Controllers\UserController::class, 'update'])->middleware('auth:api');
    Route::delete('EliminarUsuario', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('auth:api');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'role'

], function ($router) {
    Route::get('ListadoRole', [App\Http\Controllers\RoleController::class, 'index'])->middleware('auth:api');
    Route::post('IngresarRole', [App\Http\Controllers\RoleController::class, 'store'])->middleware('auth:api');
    Route::patch('ActualizarRole', [App\Http\Controllers\RoleController::class, 'update'])->middleware('auth:api');
    Route::delete('EliminarRole', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('auth:api');

    Route::post('AsignarRolUsuario', [App\Http\Controllers\RoleController::class, 'AsignarRolUsuario'])->middleware('auth:api');
    Route::get('ListaUsuarioRol', [App\Http\Controllers\RoleController::class, 'ListaUsuarioRol'])->middleware('auth:api');
});