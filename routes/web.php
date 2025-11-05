<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{
    HomeController, 
    BlogController, 
    ContectController, 
    AboutController, 
    AuthorController
};

// English home page
Route::get('/', [HomeController::class, 'index'])->name('home');
// Spanish home page
Route::get('/es', [HomeController::class, 'indexEs'])->name('home.es');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/articulos', [BlogController::class, 'articulos'])->name('articulos');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContectController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/author', [AuthorController::class, 'index'])->name('author');

Route::get('/airports/search', [HomeController::class, 'searchAirports'])->name('airports.search');
// Also expose API endpoints via web router (some environments don't auto-load routes/api.php)
Route::post('/api/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter']);
Route::post('/api/get-quote', [HomeController::class, 'getQuote']);
// HTML Sitemap
Route::get('/sitemap', [HomeController::class, 'siteMap'])->name('site.map');
// XML Sitemap
Route::get('/sitemap.xml', [HomeController::class, 'generateSitemapXml'])->name('sitemap.xml');

// Static Pages
Route::get('/terms-and-conditions', function () {
    return Inertia::render('TermsAndConditions');
})->name('terms');
Route::get('/privacy-policy', function () {
    return Inertia::render('PrivacyPolicy');
})->name('privacy.policy');
Route::get('/disclaimer', function () {
    return Inertia::render('Disclaimer');
})->name('disclaimer');
Route::get('/services', function () {
    return Inertia::render('Services');
})->name('services');
