<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/tutorials', [ArticleController::class, 'index'])->name('tutorials.index');
Route::get('/tutorials/{slug}', [ArticleController::class, 'show'])->name('tutorials.show');

Route::view('/roadmap', 'pages.roadmap')->name('roadmap');
Route::view('/community', 'pages.community')->name('community');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contribute', 'pages.contribute')->name('contribute');
