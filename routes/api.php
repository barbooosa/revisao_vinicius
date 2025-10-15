<?php

use App\Http\Controllers\{
    UserController,
    AuthController,
    BlocoController,
    CondominioController,
    ApartamentoController,
    CidadeController,
    EnderecoController,
    EstadoController,
};
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/cadastrar', [UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('user')->group(function() {
        Route::get('/me', [UserController::class, 'index']); 
        Route::get('/{id}', [UserController::class, 'show']); 
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('is.admin');
    });

    Route::prefix('estado')->group(function () {
        Route::get('/select', [EstadoController::class, 'select']);
    });

    Route::prefix('cidade')->group(function () {
        Route::get('/select/{codigo_uf}', [CidadeController::class, 'selectPorEstado']);
    });

    Route::prefix('endereco')->group(function () {
        Route::post('/', [EnderecoController::class, 'create']);
    });

    Route::prefix('condominio')->group(function() {
        Route::post('/', [CondominioController::class, 'create']);
        Route::get('/', [CondominioController::class, 'list']);
        Route::get('/buscar', [CondominioController::class, 'search']);

        Route::prefix('{condominio_id}/bloco')->group(function(){
            Route::post('/', [BlocoController::class, 'create']);
            Route::get('/', [BlocoController::class, 'list']); 
            Route::get('/{id}', [BlocoController::class, 'show']); 

            Route::prefix('{bloco_id}/apartamento')->group(function(){
                Route::post('/', [ApartamentoController::class, 'create']);
                Route::get('/', [ApartamentoController::class, 'list']);
                Route::put('/{uuid}', [ApartamentoController::class, 'update']);
                Route::delete('/{uuid}', [ApartamentoController::class, 'destroy']);
            });
        });
    });
});