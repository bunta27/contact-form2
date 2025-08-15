<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        // users テーブルへ保存（要件：「入力されたデータは users テーブルに保存」）
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            // 管理画面アクセス用のフラグが必要なら（任意）:
            // 'is_admin' => true,
        ]);
        return redirect()->route('login')->with('status', 'ユーザー登録が完了しました。ログインしてください。');
    }
}
