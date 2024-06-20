<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryTimeRequest;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryTime;
use App\Models\Curriculum;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 配信日時設定の登録/更新メソッド
    public function showDeliveryUpsert(DeliveryTimeRequest $request) {
        // トランザクション開始
        // DB::beginTransaction();
        // try {
            // DeliveryTimeモデルのgetDeliveryUpsertメソッドを実行（一括登録処理）
            $delivery_time = new DeliveryTime();
            $delivery_times = $delivery_time->getDeliveryUpsert($request);
        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return back();
        // }
        //選択中の学年idを取得
        $grade_id = $delivery_times->grade_id;
        // ①授業一覧画面にリダイレクトし②選択中の学年idを渡す
        return redirect()->route('admin.show.curriculum.list', compact('grade_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 配信日時設定画面表示メソッド
    public function showDeliveryEdit($id) {
        // DeliveryTimeモデルのgetDeliveryEditメソッドを実行
        $delivery_time = new DeliveryTime();
        $delivery_times = $delivery_time->getDeliveryEdit($id);
        $record_count = $delivery_times ? count($delivery_times) : 0;
        // dd(count($delivery_times));
        // ①配信情報設定画面を表示し②取得したdelivery_timesの情報（配列）と授業idを渡す。
        return view('admin.delivery', compact('delivery_times', 'record_count', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DeliveryTimeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 配信日時設定の削除メソッド
    public function showDeliveryDestroy(DeliveryTimeRequest $request, $id) {
                // トランザクション開始
        // DB::beginTransaction();
        // try {
            // delivery_timesテーブルのインスタンスを生成
            $delivery_time = DB::table('delivery_times')
            // 削除対象$idからレコードを取得し削除
            ->where('id', $id)->delete();
        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return back();
        // }
        // リクエストからcurriculums_idを取得
        $id = $request->curriculums_id;
        // ①配信情報設定画面にリダイレクト②リクエストから取得したcurriculums_idを渡す。
        return redirect()->route('admin.show.delivery.edit', compact('id'));
    }
}
