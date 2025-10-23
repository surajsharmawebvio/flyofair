<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController, 
    BlogController, 
    ContectController, 
    AboutController, 
    AuthorController
};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContectController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/author', [AuthorController::class, 'index'])->name('author');

Route::get('/airports/search', [HomeController::class, 'searchAirports'])->name('airports.search');
