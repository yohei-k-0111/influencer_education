<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\User\TopController as UserTopController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\ArticleController as UserArticleController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;


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
// user用
Route::prefix('user')->namespace('User\Auth')->name('user.')->group(function(){
    Route::get('login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserLoginController::class, 'login']);
    Route::post('logout', [UserLoginController::class, 'logout'])->name('logout');
    Route::get('register', [UserRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [UserRegisterController::class, 'register']);
});

Route::prefix('user')->namespace('User')->name('user.')->group(function(){
    Route::get('top', [UserTopController::class, 'showTop'])->name('show.top');
    Route::get('progress', [ProgressController::class, 'showProgress'])->name('show.progress')->middleware('auth');
    Route::get('article/{id}', [UserArticleController::class, 'showArticle'])->name('show.article')->middleware('auth');
    Route::get('profile', [ProfileController::class, 'showProfileForm'])->name('show.profile')->middleware('auth');
    Route::get('profile/edit', [ProfileController::class, 'profileEdit'])->name('profile.edit')->middleware('auth');
    Route::match(['post', 'put'], 'profile/process', [ProfileController::class, 'buttonRooting'])->name('button.rooting')->middleware('auth');
    // パスワード変更画面表示
    Route::get('password/edit', [ProfileController::class, 'passwordEdit'])->name('password.edit')->middleware('auth');
    // パスワード変更情報一時保存
    Route::post('password/temp-save', [ProfileController::class, 'tempSavePassword'])->name('password.temp_save')->middleware('auth');
    // プロフィール情報更新
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
});

// admin用
Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Auth')->name('admin.')->group(function(){
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class,'logout'])->name('logout');
    // Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function(){
    Route::get('top', [AdminTopController::class, 'showTop'])->name('show.top');
    Route::get('article_list', [AdminArticleController::class, 'showArticleList'])->name('show.article.list');
    Route::match(['get', 'post'], 'article/process', [AdminArticleController::class, 'buttonRooting'])->name('article.rooting');
    Route::get('article_create', [AdminArticleController::class, 'articleCreate'])->name('article.create');
    Route::post('article/store', [AdminArticleController::class, 'store'])->name('article.store');
    Route::put('article/update/{id}', [AdminArticleController::class, 'update'])->name('article.update');
    Route::delete('article_destroy', [AdminArticleController::class, 'destroy'])->name('article.destroy');
});