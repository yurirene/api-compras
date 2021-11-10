<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ProdutoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categorias', [CategoriaController::class, 'get']);
Route::get('/produtos/{categoria}', [ProdutoController::class, 'get']);
Route::get('/lista', [ListaController::class, 'get']);

Route::post('/add-item-lista', [ListaController::class, 'add']);