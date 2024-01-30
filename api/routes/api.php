<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Importando os controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\StreamingNowController;
use App\Http\Controllers\MusicsListController;
use App\Http\Controllers\ListenerRequestsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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
Route::group(['prefix' => 'historico-de-transmissao'], function() {
    Route::get('/{now?}', [StreamingNowController::class, 'index']);
    Route::post('/', [StreamingNowController::class, 'store']);
    Route::get('/{slug}', [StreamingNowController::class, 'show']);
    Route::patch('/{id}', [StreamingNowController::class, 'update']);
    Route::delete('/{id}', [StreamingNowController::class, 'destroy']);
});

//Rotas para endpoint de músicas
Route::group(['prefix' => 'musicas'], function() {
    Route::get('/', [MusicsListController::class, 'index']);
    Route::post('/', [MusicsListController::class, 'store']);
    Route::get('/{slug}', [MusicsListController::class, 'show']);
    Route::patch('/{id}', [MusicsListController::class, 'update']);
    Route::delete('/{id}', [MusicsListController::class, 'destroy']);
});

//Rotas para endpoint de pedidos
Route::group(['prefix' => 'pedidos-musicais'], function() {
    Route::get('/', [ListenerRequestsController::class, 'index']);
    Route::post('/', [ListenerRequestsController::class, 'store']);
    Route::get('/{id}', [ListenerRequestsController::class, 'show']);
    Route::patch('/{id}', [ListenerRequestsController::class, 'update']);
    Route::delete('/{id}', [ListenerRequestsController::class, 'destroy']);
});