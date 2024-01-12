<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Importando os controllers
use App\Http\Controllers\UserController;

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
});
