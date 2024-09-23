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
        // 授業新規登録・授業更新フォームのバリデーションロジックを定義
        return [
            'title' => 'required | max:25',
            'video_url' => 'url | max:255 | nullable',
            'description' => 'max:10 | nullable',
            'thumbnail' => 'mimes:jpeg,jpg,png | max:2048 | nullable',
        ];
    }

    public function messages() {
        // 上記のバリデーションエラー時のメッセージを定義
        return [
            'title.required' => '「授業名」は必須項目です',
            'title.max' => '「授業名」は255文字以下で入力してください',
            'video_url.url' => '「動画URL」の書式に誤りがあります',
            'video_url.max' => '「動画URL」は255文字以下で入力してください',
            'description.max' => '「授業概要」は1000文字以下で入力してください',
            'thumbnail.mimes' => '登録できる画像形式は「jpeg」「jpg」「png」形式です',
            'thumbnail.max' => '画像サイズは2MB以下にしてください',
        ];
    }
}
