<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認可が必要なら適宜変更
    }

    public function rules(): array
    {
        return [
            'name'     => ['required'],
            'email'    => ['required', 'email','unique:users,email'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'お名前を入力してください',
            'email.required'    => 'メールアドレスを入力してください',
            'email.email'       => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }
}
