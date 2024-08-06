<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\TopController as UserTopController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\ArticleController as UserArticleController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ルートまとめてみる↓
Route::prefix('user')->namespace('User')->name('user.')->group(function(){
    Route::get('top', [UserTopController::class, 'showTop'])->name('show.top')->middleware('auth');
    Route::get('progress', [ProgressController::class, 'showProgress'])->name('show.progress')->middleware('auth');
    Route::get('article/{id}', [UserArticleController::class, 'showArticle'])->name('show.article')->middleware('auth');
    Route::get('profile', [ProfileController::class, 'showProfileForm'])->name('show.profile')->middleware('auth');
    // Route::get('profile', [ProfileController::class, 'showProfileForm'])->name('profile.show')->middleware('auth');
    Route::get('profile/edit', [ProfileController::class, 'profileEdit'])->name('profile.edit')->middleware('auth');
    Route::match(['post', 'put'], 'profile/process', [ProfileController::class, 'buttonRooting'])->name('button.rooting')->middleware('auth');

    // パスワード変更画面表示
    Route::get('password/edit', [ProfileController::class, 'passwordEdit'])->name('password.edit')->middleware('auth');
    // Route::post('password/temp-save', [ProfileController::class, 'tempSavePassword'])->name('password.temp_save')->middleware('auth');
    // パスワード変更情報一時保存
    Route::post('password/temp-save', [ProfileController::class, 'tempSavePassword'])->name('password.temp_save')->middleware('auth');
    // プロフィール情報更新
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
});

// Route::view('/admin/login', 'admin/login');
Route::get('/admin/login', [App\Http\Controllers\admin\LoginController::class, 'showLoginForm']);
Route::post('/admin/login', [App\Http\Controllers\admin\LoginController::class, 'login']);
Route::post('/admin/logout', [App\Http\Controllers\admin\LoginController::class,'logout']);
Route::view('/admin/register', 'admin/register');
Route::post('/admin/register', [App\Http\Controllers\admin\RegisterController::class, 'register']);
Route::view('/admin/home', 'admin/home')->middleware('auth:admin');

Route::prefix('admin')->namespace('Admin')->name('admin')->group(function(){
    Route::get('top', [AdminTopController::class, 'showTop'])->name('show.top');
    Route::get('article_list', [AdminarticleController::class, 'showArticleList'])->name('show.article.list');
    Route::get('article_create', [AdminarticleController::class, 'showArticleCreate'])->name('show.article.create');
});