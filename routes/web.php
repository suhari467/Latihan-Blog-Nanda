<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileControler;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\PostController as PublicPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', [HomepageController::class, 'index']);
Route::get('/post', [HomepageController::class, 'post']);

Route::resource('/admin/user', UserController::class)->middleware(['auth', 'isadmin']);
Route::get('/admin/user/{user}/reset-password', [UserController::class, 'resetPassword'])->middleware(['auth', 'isadmin']);
Route::put('/admin/user/{user}/reset-password', [UserController::class, 'updatePassword'])->middleware(['auth', 'isadmin']);
Route::resource('/admin/category_post', CategoryPostController::class)->middleware(['auth', 'isadmin']);
Route::get('/admin/check-slug/category_post', [CategoryPostController::class, 'checkSlug']);

Route::resource('/user/posts', PostController::class)->middleware(['auth']);
Route::get('/user/check-slug/post', [PostController::class, 'checkSlug']);

Route::get('/login', [AuthenticateController::class, 'login'])->middleware(['guest']);
Route::post('/login', [AuthenticateController::class, 'authenticate']);
Route::get('/logout', [AuthenticateController::class, 'logout']);
Route::get('/register', [AuthenticateController::class, 'register'])->middleware(['guest']);
Route::post('/register', [AuthenticateController::class, 'store']);

Route::get('/category_post', [CategoryController::class, 'index']);
Route::get('/category_post/{category_post:slug}', [CategoryController::class, 'show']);
Route::get('/posts', [PublicPostController::class, 'index']);
Route::get('/posts/post/{post:slug}', [PublicPostController::class, 'show']);
Route::get('/posts/user/{user}', [PublicPostController::class, 'user']);

Route::get('/account', [ProfileControler::class, 'index'])->middleware(['auth']);
Route::get('/account/password', [ProfileControler::class, 'password'])->middleware(['auth']);
Route::post('/account/update', [ProfileControler::class, 'update'])->middleware(['auth']);
Route::post('/account/password', [ProfileControler::class, 'resetPassword'])->middleware(['auth']);
