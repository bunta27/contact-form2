@extends('auth.layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('btn')
    <a class="header__btn" href="{{ route('login') }}">login</a>
@endsection

@section('title')
    <h2 class="title">Register</h2>
@endsection

@section('content')
<div class="card">
    <div class="narrow">
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="form-row">
                <label for="name">お名前</label>
                <input class="name" name="name" type="text" value="{{ old('name') }}" placeholder="例: 山田　太郎">
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-row">
                <label for="email">メールアドレス</label>
                <input class="email" name="email" type="email" value="{{ old('email') }}" placeholder="例: test@example.com">
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-row">
                <label for="password">パスワード</label>
                <input class="password" name="password" type="password" placeholder="例: coachtech1106">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="submit-wrap">
                <button type="submit" class="btn-primary">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
