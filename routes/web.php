<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\CurriculumsController;
use App\Http\Controllers\ArticlesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::view('/login', 'admin.login')->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::view('/register', 'admin.register')->name('admin.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register.post');
    Route::view('/home', 'admin.home')->middleware('auth:admin')->name('admin.home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/top', [App\Http\Controllers\ArticlesController::class, 'top'])->name('top')->middleware('auth');
Route::get('/curriculums/user_stream/{id}', [CurriculumsController::class, 'user_stream'])->name('user_stream')->middleware('auth');
Route::post('/clear', [CurriculumsController::class, 'clear'])->name('clear');
Route::get('/clear', [CurriculumsController::class, 'clear'])->name('clear.get');


// 時間割ページへのルート仮
Route::get('/jikan-bu', function () {
    return view('jikanbu');
})->name('jikanbu')->middleware('auth');

// 授業進捗ページへのルート仮
Route::get('/lessons', function () {
    return view('lessons');
})->name('lessons')->middleware('auth');

// プロフィール設定ページへのルート仮
Route::get('/profile-setting', function () {
    return view('profile-setting');
})->name('profile-setting')->middleware('auth');

//お知らせページのルート仮
Route::get('/articles/{id}', [ArticlesController::class, 'show'])->name('articles.show')->middleware('auth');

