<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curriculum extends Model
{
    use HasFactory; // ダミーレコード代入機能

    // Curriculumモデルは 'curriculums' テーブルと対応を明記
    protected $table = 'curriculums';

    // factoryでインサートを許可するカラムを定義
    // ->一括代入を許可するカラムを定義に変更
    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'video_url',
        'always_delivery_flg',
        'grade_id',
        // 'created_at',
        // 'updated_at'
    ];

    // DeliveryTimeモデルと「1対多」のリレーション関係を結ぶ
    // ※外部キーを明記（誤認識防止）
    public function deliveryTimes() {
        return $this->hasMany(DeliveryTime::class, 'curriculums_id');
    }

    // Gradeモデルと「1対多」のリレーション関係を結ぶ
    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    // 授業一覧画面表示の授業データ取得
    public function getCurriculumList($request) {
        // grade_idがnullの場合、デフォルト値「1」(小学校1年生)を返す（一覧画面の初期表示時）
        $select_grade_id = $request->input('grade_id', 1);
        //curriculumsテーブルからリレーション先のdelivery_timesテーブルのデータも併せて取得
        $curriculums = Curriculum::with('deliveryTimes')->get();
        $curriculums = $curriculums->where('grade_id', $select_grade_id);

        return $curriculums;
    }

    // 登録フォームから送信された情報をcurriculumsテーブルに保存
    public function getCurriculumStore($request) {
        // デバッグのためにリクエストの内容を確認
        // dd($request);
        //curriculumsテーブルに新しいレコードを作成
        $curriculum = new Curriculum;
        // 送信情報を格納
        $curriculum->title = $request->title;
        $curriculum->description = $request->description;
        $curriculum->video_url = $request->video_url;
        $curriculum->always_delivery_flg = $request->always_delivery_flg;
        $curriculum->grade_id = $request->grade_id;
        // リクエストに画像（カリキュラムサムネイル）が存在する場合、画像ファイルを格納する。
        // DBへはstorage/images/thumbnail/ファイル名で保存する
        if ($request->hasFile('thumbnail')) {
            $filename = $request->file('thumbnail')->getClientOriginalName(); // アップロードされたファイル名を取得
            $file_path = $request->file('thumbnail')->storeAs('images/thumbnail', $filename, 'public');
            $curriculum->thumbnail = 'storage/'. $file_path; // 取得したファイル名を含むパスをDBに格納
        }
        // dd($curriculum->thumbnail);
        // 保存
        $curriculum->save();
    }

    // 編集フォームから送信された情報をcurriculumsテーブルに更新保存
    public function getCurriculumUpdate($request, $id) {
        // curriculumsテーブルの指定したidレコード情報を取得
        $curriculum = Curriculum::find($id);
        // 送信情報を格納(上書き)
        $curriculum->title = $request->title;
        $curriculum->description = $request->description;
        $curriculum->video_url = $request->video_url;
        $curriculum->always_delivery_flg = $request->always_delivery_flg;
        $curriculum->grade_id = $request->grade_id;
        // リクエストに画像（カリキュラムサムネイル）が存在する場合、画像ファイルを格納する。
        // DBへはstorage/images/thumbnail/ファイル名で保存する
        if ($request->hasFile('thumbnail')) {
            $filename = $request->file('thumbnail')->getClientOriginalName(); // アップロードされたファイル名を取得
            $file_path = $request->file('thumbnail')->storeAs('images/thumbnail', $filename, 'public');
            $curriculum->thumbnail = 'storage/'. $file_path; // 取得したファイル名を含むパスをDBに格納
        }
        // dd($curriculum->thumbnail);
        // 更新保存
        $curriculum->save();
    }
}
