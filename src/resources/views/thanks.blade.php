@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
    <p class="thanks__message">お問い合わせありがとうございました</p>
    <a href="/" class="btn">HOME</a>
</div>
@endsection
