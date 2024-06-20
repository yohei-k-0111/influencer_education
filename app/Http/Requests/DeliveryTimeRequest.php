<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class DeliveryTimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        // dd('Rules method called');
        // 配信日時設定フォームのバリデーションロジックを定義
        return [
            'delivery_times.*.date_from' => 'required | date_format:Y-m-d',
            'delivery_times.*.time_from' => 'required | date_format:H:i',
            'delivery_times.*.date_to' => 'required | date_format:Y-m-d',
            'delivery_times.*.time_to' => 'required | date_format:H:i',
        ];
    }

    public function messages() {
        // 上記のバリデーションエラー時のメッセージを定義
        return [
            'delivery_times.*.date_from.required' => '「公開開始日」は必須項目です',
            'delivery_times.*.time_from.required' => '「公開開始時間」は必須項目です',
            'delivery_times.*.date_from.date_format:Y-m-d' => '「公開開始日」の書式に誤りがあります 例:YYYY-MM-DD',
            'delivery_times.*.time_from.date_format:H:i' => '「公開開始時間」の書式に誤りがあります 例:hh:mm',
            'delivery_times.*.date_to.required' => '「公開終了日」は必須項目です',
            'delivery_times.*.time_to.required' => '「公開終了時間」は必須項目です',
            'delivery_times.*.date_to.date_format:Y-m-d' => '「公開終了日」の書式に誤りがあります 例:YYYY-MM-DD',
            'delivery_times.*.time_to.date_format:H:i' => '「公開終了時間」の書式に誤りがあります 例:hh:mm',
        ];
    }
    /**
     * withValidator
     * 
     * @param  [type] $validator
     * @return void
     */
    // 終了日時と開始日時の比較ロジック（$delivery_to <= $delivery_from）であればエラー
    // $validator：バリデーションロジック
    protected function withValidator($validator) {
        $this->datetimeValidator($validator);
    }
    protected function datetimeValidator($validator) {
        // 通常のバリデーション完了後に実行する
        $validator->after(function ($validator) {
            $delivery_times = $this->input('delivery_times', []); // 'delivery_times'配列を取得し空の配列をデフォルトに設定
            foreach ($delivery_times as $key => $delivery_time) {
                $delivery_from = $delivery_time['date_from'] . ' ' . $delivery_time['time_from'] . ':00';
                $delivery_to = $delivery_time['date_to'] . ' ' . $delivery_time['time_to'] . ':00';
                // carbonインスタンスで文字列を日時オブジェクトとして処理
                $delivery_from = new Carbon($delivery_from);
                $delivery_to = new Carbon($delivery_to);
                // 開始日時・終了日時がdatetime形式でなければエラーメッセージを追加
                $validator->errors()->add("delivery_times.$key.datetime", '日時形式に誤りがあります');
                continue;
                // 日時を比較し、終了日時が開始日時よりも後でなければ（<=）バリデーターにエラーメッセージを追加
                if ($delivery_to <= $delivery_from) {
                    $validator->errors()->add("delivery_times.$key.datetime_to", '「公開終了日時」は公開開始日時よりも後の日時を設定してください');
                }
            }
        });
    }
}
