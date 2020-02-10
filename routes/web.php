<?php

use App\Http\Controllers\BotFernandoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BotFernandoController::class, 'index']);
Route::post('/load-accounts', [BotFernandoController::class, 'uploadAccountFile'])->name('uploadAccountFile');
Route::get('/login-accounts', [BotFernandoController::class, 'loginAccount'])->name('loginAccount');
// Route::get('/votar-blogs', [BotFernandoController::class, 'voteInBlogs'])->name('voteInBlogs');
Route::post('/votar-blogs', [BotFernandoController::class, 'voteInBlogs'])->name('voteInBlogs');
Route::post('/votar-perfiles', [BotFernandoController::class, 'voteInProfile'])->name('voteInProfile');
Route::post('/votar-imagenes', [BotFernandoController::class, 'voteInImage'])->name('voteInImage');
Route::post('/crear-blog', [BotFernandoController::class, 'createBlog'])->name('createBlog');
Route::post('/eliminar-blog', [BotFernandoController::class, 'destroyBlog'])->name('destroyBlog');
Route::get('/user', [BotFernandoController::class, 'getUser'])->name('getUser');
