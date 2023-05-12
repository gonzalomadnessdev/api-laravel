<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\AutoresController;
use App\Http\Controllers\MockupController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class , 'login']);
    Route::post('logout', [AuthController::class , 'logout']);
    Route::post('refresh', [AuthController::class , 'refresh']);
    Route::get('me', [AuthController::class , 'me']);
    Route::post('register', [AuthController::class , 'register']);
});



Route::group([

    'middleware' => 'auth:api'

], function ($router) {
    Route::get('/libros', [LibrosController::class , 'getLibros']);
    Route::get('/libros/{id}', [LibrosController::class , 'getLibro']);
    Route::post('/libros', [LibrosController::class , 'createLibro']);
    Route::delete('/libros/{id}', [LibrosController::class , 'removeLibro']);
    Route::put('/libros/{id}', [LibrosController::class , 'updateLibro']);

    Route::get('/autores', [AutoresController::class , 'getAutores']);
    Route::post('/autores', [AutoresController::class , 'createAutor']);
});

Route::get('users', [MockupController::class , 'listarUsuarios']);
