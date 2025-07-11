<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminController;
use App\Models\Category;

// Route untuk halaman publik (frontend)

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category:category_id}', [HomeController::class, 'showCategoryNews'])->name('categories.show');
Route::get('/category/{category}', [HomeController::class, 'showCategoryNews'])->name('category.show');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/news/create', [App\Http\Controllers\NewsController::class, 'create'])->name('news.create');
Route::get('/news/{news}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::get('/news/{news_id}', [HomeController::class, 'showSingleNews'])->name('news.single');
//Route::get('/news/{news}', [HomeController::class, 'showSingleNews'])->name('news.single');
//Route::get('/news/{news:slug}', [HomeController::class, 'showSingleNews'])->name('news.single');
Route::post('/comment', [HomeController::class, 'storeComment'])->name('comment.store');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');




// Rute login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/verify-email/{token}', [AuthController::class, 'handleVerification'])->name('verify.email');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); // Biarkan hanya ini



Route::middleware(['auth'])->group(function () {
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
   Route::get('/profile', [DashboardController::class, 'profile'])->name('profil.index');
   Route::get('/reset/password', [DashboardController::class, 'resetPassword'])->name('dashboard.resetPassword');

   Route::get('/users', [UserController::class, 'index'])->name('users.index');
   Route::post('/users', [UserController::class, 'store'])->name('users.store');
   Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
   Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
   Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


   // Perbaikan rute berita

   Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
   Route::post('/news', [App\Http\Controllers\NewsController::class, 'store'])->name('news.store');
   Route::get('/news/{news}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
   Route::get('/news/{news}/edit', [App\Http\Controllers\NewsController::class, 'edit'])->name('news.edit');
   Route::put('/news/{news}', [App\Http\Controllers\NewsController::class, 'update'])->name('news.update');
   Route::delete('/news/{news}', [App\Http\Controllers\NewsController::class, 'destroy'])->name('news.destroy');

   Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
   Route::get('/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
   Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
   Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
   Route::get('/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
   Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
   Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');

   Route::get('/comments', [App\Http\Controllers\CommentController::class, 'index'])->name('comments.index');
   Route::get('/comments/create', [App\Http\Controllers\CommentController::class, 'create'])->name('comments.create');
   Route::get('/comments/{comment}/edit', [App\Http\Controllers\CommentController::class, 'edit'])->name('comments.edit');
   Route::put('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
   Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
   Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
   // Tambahkan baris ini

   Route::get('/media', [App\Http\Controllers\MediaController::class, 'index'])->name('media.index');
   Route::get('/media/create', [App\Http\Controllers\MediaController::class, 'create'])->name('media.create');
   Route::post('/media', [App\Http\Controllers\MediaController::class, 'store'])->name('media.store');
   Route::get('/media/{media}', [App\Http\Controllers\MediaController::class, 'show'])->name('media.show');
   Route::get('/media/{media}/edit', [App\Http\Controllers\MediaController::class, 'edit'])->name('media.edit');
   Route::put('/media/{media}', [App\Http\Controllers\MediaController::class, 'update'])->name('media.update');
   Route::delete('/media/{media}', [App\Http\Controllers\MediaController::class, 'destroy'])->name('media.destroy');
});
