<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
     public function rules() {
        // dd('Rules method called');
        // 授業新規登録・授業更新フォームのバリデーションロジックを定義
        return [
            'title' => 'required | max:255',
            'video_url' => 'url | max:255 | nullable',
            'description' => 'max:2000 | nullable',
            'thumbnail' => 'mimes:jpeg,jpg,png | max:2048 | nullable',
        ];
    }

    public function messages() {
        // 上記のバリデーションエラー時のメッセージを定義
        return [
            'title.required' => '「授業名」は必須項目です',
            'title.max:50' => '「授業名」は全角174文字以下で入力してください',
            'video_url.url' => '「動画URL」の書式に誤りがあります',
            'video_url.max:255' => '「動画URL」は半角255以下で入力してください',
            'description.max:2000' => '「授業概要」は全角1000文字以下で入力してください',
            'thumbnail.mimes:jpeg,jpg,png' => '「サムネイル画像」はjpeg,jpg,png形式にしてください',
            'thumbnail.max:2048KB' => '「サムネイル画像」は2MB以下のファイルサイズにしてください',
        ];
    }
}
