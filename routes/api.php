<?php

use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\Auth\Api\RegisterController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('expenses',ExpenseController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy'])
    ->middleware('auth:sanctum');

Route::prefix('auth')->group(function(){
    Route::post('login',[LoginController::class,'login']);
    Route::post('register',[RegisterController::class,'register']);
    Route::post('logout',[LoginController::class,'logout'])
        ->middleware('auth:sanctum');
});

Route::get('/test-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados estabelecida com sucesso!";
    } catch (\Exception $e) {
        return "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
});