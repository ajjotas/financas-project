<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\CreditoController;

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

Route::get('/instituicao/getAll', [InstituicaoController::class, 'getAll']);
Route::get('/convenio/getAll', [ConvenioController::class, 'getAll']);
Route::post('/credito/simulacaoCredito', [CreditoController::class, 'simulacaoCredito']);