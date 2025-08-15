@extends('auth.layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('btn')
    <a class="header__btn" href="{{ route('register') }}">register</a>
@endsection

@section('title')
    <h2 class="title">Login</h2>
@endsection

@section('content')
<div class="card">
    <div class="narrow">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="form-row">
                <label for="email">メールアドレス</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="例: test@example.com" autofocus>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-row">
                <label for="password">パスワード</label>
                <input id="password" name="password" type="password" placeholder="例: coachtech1106">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="submit-wrap">
                <button type="submit" class="btn-primary">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection
