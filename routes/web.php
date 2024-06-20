<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\DeliveryController;


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
Route::get('/admin/top', function () {
    return view('admin/top');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 管理機能（admin）グループ化（パス・namespace・ルート名）
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // 授業一覧画面表示
    Route::get('/curriculum_list', [CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');
    // 授業新規登録画面表示
    Route::get('/curriculum_create', [CurriculumController::class, 'showCurriculumCreate'])->name('show.curriculum.create');
    // 授業新規登録
    Route::post('/curriculum_store', [CurriculumController::class, 'showCurriculumStore'])->name('show.curriculum.store');
    // 授業設定画面表示
    Route::get('/curriculum_edit/{id}', [CurriculumController::class, 'showCurriculumEdit'])->name('show.curriculum.edit');
    // 授業設定更新
    Route::put('/curriculum_update/{id}', [CurriculumController::class, 'showCurriculumUpdate'])->name('show.curriculum.update');
    // 配信日時設定画面表示
    Route::get('/delivery_edit/{id}', [DeliveryController::class, 'showDeliveryEdit'])->name('show.delivery.edit');
    // 配信日時設定登録・更新
    Route::post('/delivery_upsert', [DeliveryController::class, 'showDeliveryUpsert'])->name('show.delivery.upsert');
    // 配信日時設定削除
    Route::delete('/delivery_destroy/{id}', [DeliveryController::class, 'showDeliveryDestroy'])->name('show.delivery.destroy');

});