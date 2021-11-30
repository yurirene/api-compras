<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * ROTAS DA LISTA
*/
Route::get('/categorias', [CategoriaController::class, 'get']);
Route::get('/produtos/{categoria}', [ProdutoController::class, 'get']);
Route::get('/lista', [ListaController::class, 'get']);
Route::post('/add-item-lista', [ListaController::class, 'add']);
Route::post('/edit-item-lista', [ListaController::class, 'edit']);
Route::post('/delete-item-lista', [ListaController::class, 'delete']);


/**
 * ROTAS DE COMPRAS
 */
Route::get('/compra', [CompraController::class, 'get']);
Route::post('/comprar-item', [CompraController::class, 'comprarItem']);
Route::post('/iniciar-compra', [CompraController::class, 'iniciar']);
Route::post('/lista-compra', [CompraController::class, 'lista']);
Route::post('/delete-item-lista-compra', [CompraController::class, 'delete']);

