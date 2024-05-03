<?php

use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// tutte le rotte presenti in api.php iniziano con "api/"
Route::get('/posts', [PostController::class, 'index']);

// rotta per la show del singolo post
Route::get('/posts/{slug}', [PostController::class, 'show']);


// creo la rotta che riceve i dati dal form front-end e li memorizza nel db
Route::post('/new-contact', [LeadController::class, 'store']);