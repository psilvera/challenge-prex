<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GiphyApiController;
use App\Http\Middleware\LoginUserMiddleware;

/**
 * Login
 */
Route::post('/giphy/login', [AuthController::class, 'login'])->withoutMiddleware(LoginUserMiddleware::class);

/**
 * Rutas protegidas
 */
Route::middleware('auth:api')->group(function () {

    /**
     * Buscar GIFs
     * Filtros query, limit y offset
     */
    Route::get('/giphy/search', [GiphyApiController::class, 'searchGifs']);

    /**
     * Buscar GIF por ID
     */
    Route::get('/giphy/id/{id}', [GiphyApiController::class, 'getGifById']);

    /**
     * Guardar GIF como favorito
     */
    Route::post('/giphy/favorite', [GiphyApiController::class, 'saveFavoriteGif']);
});
