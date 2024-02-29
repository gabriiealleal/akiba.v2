<?php

use Illuminate\Support\Facades\Route;

//Importando os controllers
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShowsController;
use App\Http\Controllers\StreamingNowController;
use App\Http\Controllers\MusicsListController;
use App\Http\Controllers\ListenerRequestsController;
use App\Http\Controllers\PodcastsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\EventsController;

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
    Route::get('/', [UsersController::class, 'index']);
    Route::post('/', [UsersController::class, 'store']);
    Route::get('/{slug}', [UsersController::class, 'show']);
    Route::patch('/{id}', [UsersController::class, 'update']);
    Route::delete('/{id}', [UsersController::class, 'destroy']);
});

//Rotas para endpoint de programas
Route::group(['prefix' => 'programas'], function() {
    Route::get('/', [ShowsController::class, 'index']);
    Route::post('/', [ShowsController::class, 'store']);
    Route::get('/{slug}', [ShowsController::class, 'show']);
    Route::patch('/{id}', [ShowsController::class, 'update']);
    Route::delete('/{id}', [ShowsController::class, 'destroy']);
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

//Rotas para endpoint de podcasts
Route::group(['prefix' => 'podcasts'], function() {
    Route::get('/', [PodcastsController::class, 'index']);
    Route::post('/', [PodcastsController::class, 'store']);
    Route::get('/{slug}', [PodcastsController::class, 'show']);
    Route::patch('/{id}', [PodcastsController::class, 'update']);
    Route::delete('/{id}', [PodcastsController::class, 'destroy']);
});



//Rotas para endpoint de postagens
Route::group(['prefix' => 'postagens'], function() {
    Route::get('/', [PostsController::class, 'index']);
    Route::post('/', [PostsController::class, 'store']);
    Route::get('/{slug}', [PostsController::class, 'show']);
    Route::patch('/{id}', [PostsController::class, 'update']);
    Route::delete('/{id}', [PostsController::class, 'destroy']);
});

//Rotas para endpoint de reviews
Route::group(['prefix' => 'reviews'], function() {
    Route::get('/', [ReviewsController::class, 'index']);
    Route::post('/', [ReviewsController::class, 'store']);
    Route::get('/{slug}', [ReviewsController::class, 'show']);
    Route::patch('/{id}', [ReviewsController::class, 'update']);
    Route::delete('/{id}', [ReviewsController::class, 'destroy']);
});

//Rotas para endpoint de eventos
Route::group(['prefix' => 'eventos'], function () {
    Route::get('/', [EventsController::class, 'index']);
    Route::post('/', [EventsController::class, 'store']);
    Route::get('/{slug}', [EventsController::class, 'show']);
    Route::patch('/{id}', [EventsController::class, 'update']);
    Route::delete('/{id}', [EventsController::class, 'destroy']);
});
