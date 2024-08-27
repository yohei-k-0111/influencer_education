<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordEditRequest extends FormRequest
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
        // $rules = [
        if ($this->isMethod('POST') && $this->filled('password')) {
            return [
                'password' => ['required', 'min:8', 'max:50', 'confirmed'],
                'password_confirmation' => ['required'],
            ];
        }
        return [];
    }

    /**
     * 項目名
     *
     * @return array
     */

    public function attributes()
    {
        return [
            'password' => 'パスワード',
        ];
    }

        /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'password.required' => ':attributeが入力されていません。',
            'password.min' => ':attributeは半角半角8〜50文字にして下さい。',
            'password.max' => ':attributeは半角半角8〜50文字にして下さい。',
            'password.confirmed' => ':attributeが一致しません。',
        ];
    }
}
