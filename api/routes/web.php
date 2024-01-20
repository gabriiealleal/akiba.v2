<?php

use Illuminate\Support\Facades\Route;

//Importando os controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\StreamingNowController;

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

Route::get('/', function () {
    return view('welcome');
});


//Rotas para endpoint de usuários
Route::group(['prefix' => 'usuarios'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{slug}', [UserController::class, 'show']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

//Rotas para endpoint de programas
Route::group(['prefix' => 'programas'], function() {
    Route::get('/', [ShowController::class, 'index']);
    Route::post('/', [ShowController::class, 'store']);
    Route::get('/{slug}', [ShowController::class, 'show']);
    Route::patch('/{id}', [ShowController::class, 'update']);
    Route::delete('/{id}', [ShowController::class, 'destroy']);
});

//Rotas para endpoint de histórico de transmissão
Route::group(['prefix' => 'historico_de_transmissao'], function() {
    Route::get('/', [StreamingNowController::class, 'index']);
});