<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DeliveryTime extends Model
{
    use HasFactory; // ダミーレコード代入機能

    // factoryでインサートを許可するカラムを定義
    // ->一括代入を許可するカラムを定義に変更
    protected $fillable = [
        'curriculums_id',
        'delivery_from',
        'delivery_to',
        // 'created_at',
        // 'updated_at'
    ];

    // 指定プロパティを日時を扱うCarbonインスタンスとしてキャスト（型変換）する
    protected $dates = [
        'delivery_from',
         'delivery_to'
        ];

    // Curriculumモデルと「1対多」のリレーション関係を結ぶ
    // ※外部キーを明記（誤認識防止）
    public function curriculum() {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }

    // 配信日時設定画面表示の配信データ取得
    public function getDeliveryEdit($id) {
        // delivery_timesテーブルからcurriculums_idが指定値($id)のレコードを全て取得
        $delivery_times = DeliveryTime::where('curriculums_id', $id)->get();
        // carbonインスタンスを使ってdatetime型をdate型とtime型にフォーマット
        // コールバック関数map()を対象のコレクションに実行し、新たなコレクションで返す
        $delivery_times = $delivery_times->map(function($delivery_time) {
            // 各プロパティを配列ではなくオブジェクト形式として返すよう明示
            return(object) [
                'id' => $delivery_time->id,
                'curriculums_id' => $delivery_time->curriculums_id,
                'date_from' => $delivery_time->delivery_from->format('Y-m-d'),
                'time_from' => $delivery_time->delivery_from->format('H:i'),
                'date_to' => $delivery_time->delivery_to->format('Y-m-d'),
                'time_to' => $delivery_time->delivery_to->format('H:i'),
            ];
        });
        // $delivery_timesがnullの場合は空のコレクションを設定
        if (is_null($delivery_times)) {
            $delivery_times = collect();
        }
        return $delivery_times;
    }

    // 編集フォームから送信された複数レコードの情報をdelivery_timesテーブルに一括で登録または更新
    public function getDeliveryUpsert($request) {
        // $requestからの情報を取得
        $delivery_times = $request->input('records');
        // 取得データの整形　->配列$upsert_dataの初期化
        $upsert_data = [];
        // 取得データを$upset_dataに配してDBに適した形にする
        foreach ($delivery_times as $delivery_time) {
            $upsert_data[] = [
                'id' => $delivery_time['id'] ?? null,
                'curriculums_id' => $delivery_time['curriculums_id'],
                // 開始dateとtime,終了dateとtimeをそれぞれdatetime型に結合
                'delivery_from' => $delivery_time['date_from'] . ' ' . $delivery_time['time_from'] . ':00',
                'delivery_to' => $delivery_time['date_to'] . ' ' . $delivery_time['time_to'] . ':00',
            ];
        }
        // Eloquentでdelivery_timesテーブルを対象にupsertメソッドを使用（データの登録または更新）
        // idを参照して存在すれば更新、存在しなければレコードを追加して登録する。
        DeliveryTime::upsert($upsert_data,['id']);

        // リクエストにある選択中のcurriculums_idから辿ってgrade_idを取得して返す
        $curriculums_id = $request->curriculums_id;
        $grade_id = DB::table('curriculums')->where('id', $curriculums_id)->select('grade_id')->first();
        return $grade_id;
    }
}
