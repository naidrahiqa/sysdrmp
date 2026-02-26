<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/tutorials', [ArticleController::class, 'index'])->name('tutorials.index');
Route::get('/tutorials/{slug}', [ArticleController::class, 'show'])->name('tutorials.show');

Route::view('/roadmap', 'pages.roadmap')->name('roadmap');
Route::view('/community', 'pages.community')->name('community');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contribute', 'pages.contribute')->name('contribute');

// ─── Admin Routes ──────────────────────────────────────────────────────────
// Public: Login / Logout
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout',[AdminLoginController::class, 'logout'])->name('logout');
});

// Protected: Admin Dashboard (behind admin.auth middleware)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/',                           [AdminController::class, 'index'])->name('dashboard');
    Route::get('/articles',                   [AdminController::class, 'articles'])->name('articles');
    Route::get('/articles/create',            [AdminController::class, 'create'])->name('articles.create');
    Route::post('/articles',                  [AdminController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit',    [AdminController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}',         [AdminController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}',      [AdminController::class, 'destroy'])->name('articles.destroy');
    Route::post('/articles/preview',          [AdminController::class, 'preview'])->name('articles.preview');
});
