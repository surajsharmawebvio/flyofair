<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{
    HomeController, 
    BlogController, 
    ContectController, 
    AboutController, 
    AuthorController
};

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

// Public API Routes
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter']);
Route::post('/get-quote', [HomeController::class, 'getQuote']);
Route::post('/contact/submit', [ContectController::class, 'submit']);
