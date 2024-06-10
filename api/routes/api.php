<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Importando os controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShowsController;
use App\Http\Controllers\StreamingNowController;
use App\Http\Controllers\MusicsListController;
use App\Http\Controllers\ListenerRequestsController;
use App\Http\Controllers\PodcastsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FilesRepositoryController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TeamCalendarController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\ListenerOfTheMonthController;
use App\Http\Controllers\PlaylistBattleController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\NotificationTeamController;
use App\Http\Controllers\Top10MusicsController;


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

/*
|-------------------------------------------------------------------
| Rotas com autenticação
|-------------------------------------------------------------------
| Essas rotas só podem ser acessadas por usuários com um token válido
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    //Usuários
    Route::group(['prefix' => 'usuarios'], function () {
        Route::post('/', [UsersController::class, 'store']);
        Route::patch('/{id}', [UsersController::class, 'update']);
        Route::delete('/{id}', [UsersController::class, 'destroy']);
    });

    //Programas
    Route::group(['prefix' => 'programas'], function () {
        Route::post('/', [ShowsController::class, 'store']);
        Route::patch('/{id}', [ShowsController::class, 'update']);
        Route::delete('/{id}', [ShowsController::class, 'destroy']);
    });

    //Histórico de transmissão
    Route::group(['prefix' => 'historico-de-transmissao'], function() {
        Route::post('/', [StreamingNowController::class, 'store']);
        Route::patch('/{id}', [StreamingNowController::class, 'update']);
        Route::delete('/{id}', [StreamingNowController::class, 'destroy']);
    });

    //Músicas
    Route::group(['prefix' => 'musicas'], function() {
        Route::patch('/{id}', [MusicsListController::class, 'update']);
        Route::delete('/{id}', [MusicsListController::class, 'destroy']);
    });

    //Pedidos
    Route::group(['prefix' => 'pedidos-musicais'], function() {
        Route::post('/', [ListenerRequestsController::class, 'store']);
        Route::patch('/{id}', [ListenerRequestsController::class, 'update']);
        Route::delete('/{id}', [ListenerRequestsController::class, 'destroy']);
    });

    //Podcasts
    Route::group(['prefix' => 'podcasts'], function() {
        Route::post('/', [PodcastsController::class, 'store']);
        Route::patch('/{id}', [PodcastsController::class, 'update']);
        Route::delete('/{id}', [PodcastsController::class, 'destroy']);
    });

    //Postagens
    Route::group(['prefix' => 'postagens'], function() {
        Route::post('/', [PostsController::class, 'store']);
        Route::patch('/{id}', [PostsController::class, 'update']);
        Route::delete('/{id}', [PostsController::class, 'destroy']);
    });

    //Reviews
    Route::group(['prefix' => 'reviews'], function() {
        Route::post('/', [ReviewsController::class, 'store']);
        Route::patch('/{id}', [ReviewsController::class, 'update']);
        Route::delete('/{id}', [ReviewsController::class, 'destroy']);
    });

    //Eventos
    Route::group(['prefix' => 'eventos'], function () {
        Route::post('/', [EventsController::class, 'store']);
        Route::patch('/{id}', [EventsController::class, 'update']);
        Route::delete('/{id}', [EventsController::class, 'destroy']);
    });

    //Tarefas
    Route::group(['prefix' => 'tarefas'], function () {
        Route::post('/', [TasksController::class, 'store']);
        Route::patch('/{id}', [TasksController::class, 'update']);
        Route::delete('/{id}', [TasksController::class, 'destroy']);
    });

    //Notificações da equipe
    Route::group(['prefix' => 'notificacoes'], function () {
        Route::post('/', [NotificationTeamController::class, 'store']);
        Route::patch('/{id}', [NotificationTeamController::class, 'update']);
        Route::delete('/{id}', [NotificationTeamController::class, 'destroy']);
    });    

    //Calendário da equipe
    Route::group(['prefix' => 'calendario-da-equipe'], function () {
        Route::post('/', [TeamCalendarController::class, 'store']);
        Route::patch('/{id}', [TeamCalendarController::class, 'update']);
        Route::delete('/{id}', [TeamCalendarController::class, 'destroy']);
    });

    //Youtube
    Route::group(['prefix' => 'youtube'], function () {
        Route::post('/', [YoutubeController::class, 'store']);
        Route::patch('/{id}', [YoutubeController::class, 'update']);
        Route::delete('/{id}', [YoutubeController::class, 'destroy']);
    });

    //Repositório de arquivos
    Route::group(['prefix' => 'repositorio-de-arquivos'], function () {
        Route::post('/', [FilesRepositoryController::class, 'store']);
        Route::patch('/{id}', [FilesRepositoryController::class, 'update']);
        Route::delete('/{id}', [FilesRepositoryController::class, 'destroy']);
    });

    //Ouvinte do mês
    Route::group(['prefix' => 'ouvinte-do-mes'], function () {
        Route::post('/', [ListenerOfTheMonthController::class, 'store']);
        Route::patch('/{id}', [ListenerOfTheMonthController::class, 'update']);
        Route::delete('/{id}', [ListenerOfTheMonthController::class, 'destroy']);
    });

    //Batalha de playlist
    Route::group(['prefix' => 'batalha-de-playlist'], function () {
        Route::patch('/{id}', [PlaylistBattleController::class, 'update']);
    });

    //Formulários
    Route::group(['prefix' => 'formularios'], function () {
        Route::patch('/{id}', [FormsController::class, 'update']);
        Route::delete('/{id}', [FormsController::class, 'destroy']);
    });

    //Top 10 músicas
    Route::group(['prefix' => 'top-musicas'], function() {
        Route::patch('/{id}', [Top10MusicsController::class, 'update']);
    });
});

/*
|-------------------------------------------------------------------
| Rotas sem autenticação
|-------------------------------------------------------------------
| Essas rotas podem ser acessadas por qualquer usuário
|
*/

//Rota de autenticação
Route::post('/login', [AuthController::class, 'login']);
Route::get('/verificarlogin', [AuthController::class, 'verifyLogin']);
Route::post('/deslogar', [AuthController::class, 'logout']);

//Usuários
Route::group(['prefix' => 'usuarios'], function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::get('/{slug}', [UsersController::class, 'show']);
});

//Programas
Route::group(['prefix' => 'programas'], function() {
    Route::get('/', [ShowsController::class, 'index']);
    Route::get('/{slug}', [ShowsController::class, 'show']);
});

//Histórico de transmissão
Route::group(['prefix' => 'historico-de-transmissao'], function() {
    Route::get('/{now?}', [StreamingNowController::class, 'index']);
    Route::get('/{slug}', [StreamingNowController::class, 'show']);
});

//Músicas
Route::group(['prefix' => 'musicas'], function() {
    Route::post('/', [MusicsListController::class, 'store']);
    Route::get('/', [MusicsListController::class, 'index']);
    Route::get('/{slug}', [MusicsListController::class, 'show']);
});

//Pedidos
Route::group(['prefix' => 'pedidos-musicais'], function() {
    Route::get('/', [ListenerRequestsController::class, 'index']);
    Route::get('/{id}', [ListenerRequestsController::class, 'show']);
});

//Podcasts
Route::group(['prefix' => 'podcasts'], function() {
    Route::get('/', [PodcastsController::class, 'index']);
    Route::get('/{slug}', [PodcastsController::class, 'show']);
});

//Postagens
Route::group(['prefix' => 'postagens'], function() {
    Route::get('/', [PostsController::class, 'index']);
    Route::get('/{slug}', [PostsController::class, 'show']);
});

//Reviews
Route::group(['prefix' => 'reviews'], function() {
    Route::get('/', [ReviewsController::class, 'index']);
    Route::get('/{slug}', [ReviewsController::class, 'show']);
});

//Eventos
Route::group(['prefix' => 'eventos'], function () {
    Route::get('/', [EventsController::class, 'index']);
    Route::get('/{slug}', [EventsController::class, 'show']);
});

//Tarefas
Route::group(['prefix' => 'tarefas'], function () {
    Route::get('/{user?}', [TasksController::class, 'index']);
    Route::get('/{slug}', [TasksController::class, 'show']);
});

//Notificações da equipe
Route::group(['prefix' => 'notificacoes'], function () {
    Route::get('/{user?}', [NotificationTeamController::class, 'index']);
    Route::get('/{slug}', [NotificationTeamController::class, 'show']);
});

//Rotas para calendário da equipe
Route::group(['prefix' => 'calendario-da-equipe'], function () {
    Route::get('/', [TeamCalendarController::class, 'index']);
    Route::get('/{slug}', [TeamCalendarController::class, 'show']);
});

//Rotas para endpoint de Youtube
Route::group(['prefix' => 'youtube'], function () {
    Route::get('/', [YoutubeController::class, 'index']);
    Route::get('/{id}', [YoutubeController::class, 'show']);
});

//Rotas para endpoint repositório de arquivos
Route::group(['prefix' => 'repositorio-de-arquivos'], function () {
    Route::get('/', [FilesRepositoryController::class, 'index']);
    Route::get('/{id}', [FilesRepositoryController::class, 'show']);
});

//Rotas para endpoint de ouvinte do mês
Route::group(['prefix' => 'ouvinte-do-mes'], function () {
    Route::get('/', [ListenerOfTheMonthController::class, 'index']);
    Route::get('/{id}', [ListenerOfTheMonthController::class, 'show']);
});

//batalha de playlist
Route::group(['prefix' => 'batalha-de-playlist'], function () {
    Route::get('/', [PlaylistBattleController::class, 'index']);
});

//Formulários
Route::group(['prefix' => 'formularios'], function () {
    Route::post('/', [FormsController::class, 'store']);
    Route::get('/', [FormsController::class, 'index']);
    Route::get('/{id}', [FormsController::class, 'show']);
});

