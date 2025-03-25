<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = auth()->id();

        return [
            'name' => ['required', 'max:255'],
            'name_kana' => ['required', 'regex:/\A[ァ-ヴー]+\z/u', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'profile_image' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg'],
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
            'name' => 'ユーザーネーム',
            'name_kana' => 'カナ',
            'email' => 'メールアドレス',
            'profile_image' => 'プロフィール画像',
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required' => ':attributeが入力されていません。',
            'name.max' => ':attributeは:max字以内にしてください。',
            'name_kana.required' => ':attributeが入力されていません。',
            'name_kana.regex' => ':attributeはカタカナで入力してください',
            'name_kana.max' => ':attributeは:max字以内にしてください。',
            'email.required' => ':attributeが入力されていません。',
            'email.email' => ':attributeの形式が正しくありません。',
            'email.max' => ':attributeは半角:max文字以内にして下さい。',
            'email.unique' => ':attributeがすでに使われています。',
            'profile_image.image' => '登録できる画像形式は:mimes形式です。',
            'profile_image.max' => '画像サイズは2MB以下にしてください。',
            'profile_image.mimes' => '登録できる画像形式は:mimes形式です。',
        ];
    }
}
