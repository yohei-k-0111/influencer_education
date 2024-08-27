<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
    public function rules()
    {
        return [
            'posted_date' => 'required|date',
            'title' => 'required|max:255',
            'article_content' => 'required|string',
        ];


    }

    /**
    * 項目名
    *
    * @return array
    */
    public function attributes()
    {
        return [
            'posted_date' => '投稿日時',
            'title' => 'タイトル',
            'article_content' => '本文',
        ];
    }
 
    /**
    * エラーメッセージ
    *
    * @return array
    */
    public function messages() 
    {
        return [
            'posted_date.required' => ':attributeを選択してください。',
            'posted_date.date' => ':attributeの形式が異なります。',
            'title.required' => ':attributeが入力されていません。',
            'title.max' => ':attribute255文字以内にして下さい。',
            'article_content.required' => ':attributeが入力されていません。',
        ];
    }
}
