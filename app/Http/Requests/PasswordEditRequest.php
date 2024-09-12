<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        return [
            'current_password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail($this->messages()['current_password.match'] ?? '現在のパスワードが一致しません。');
                    }
                },
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'confirmed',
                function ($attribute, $value, $fail) {
                    if (Hash::check($value, Auth::user()->password)) {
                        $fail($this->messages()['new_password.different'] ?? '新しいパスワードが現在のパスワードと重複しています。');
                    }
                },
                Rule::notIn([$this->current_password])  // 現在のパスワードと同じ値を禁止
            ],
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
            'current_password' => '現在のパスワード',
            'new_password' => '新しいパスワード',
        ];
    }

        /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'current_password.required' => ':attributeが入力されていません。',
            'current_password.match' => ':attributeが一致しません。',
            'new_password.required' => ':attributeが入力されていません。',
            'new_password.min' => ':attributeは半角半角8〜50文字にしてください。',
            'new_password.max' => ':attributeは半角半角8〜50文字にしてください。',
            'new_password.confirmed' => ':attributeが一致しません。',
            'new_password.not_in' => ':attributeが現在のパスワードと重複しています。',
            'new_password.different' => ':attributeが現在のパスワードと重複しています。',
        ];
    }
}
