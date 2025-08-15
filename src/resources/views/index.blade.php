@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="contact-form__content">
        <div class="contact-form__heading">
            <h2>Contact</h2>
        </div>
        <form class="form" action="/confirm" method="post" novalidate>
        @csrf
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お名前</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content name-group">
                    <div class="form__input--text-name">
                        <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}" />
                        @error('last_name')
                            <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form__input--text-name">
                        <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}" />
                        @error('first_name')
                            <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">性別</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="radio-group">
                        <label class="radio">
                            <input type="radio" name="gender" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} >
                            <span>男性</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }} >
                            <span>女性</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="gender" value="other" {{ old('gender') === 'other' ? 'checked' : '' }} >
                            <span>その他</span>
                        </label>
                    </div>
                    @error('gender')
                        <div class="gender__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" />
                        @error('email')
                            <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">電話番号</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="tel-group">
                        <div class="form__input--text-tel">
                            <input type="tel" name="tel1" placeholder="080" value="{{ old('tel1') }}" />
                            <span>-</span>
                            <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2') }}" />
                            <span>-</span>
                            <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3') }}" />
                        </div>
                        @if($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                            <div class="form__error">
                            {{ $errors->first('tel1') ?: $errors->first('tel2') ?: $errors->first('tel3') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}" />
                        @error('address')
                            <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}" />
                        @error('building')
                            <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせの種類</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content select-stack">
                    <div class="select-group">
                        <div class="select-inner">
                            <select name="category_id">
                                <option value="">選択してください</option>
                                <option value="1">商品のお届けについて</option>
                                <option value="2">商品の交換について</option>
                                <option value="3">商品トラブル</option>
                                <option value="4">ショップへのお問い合わせ</option>
                                <option value="5">その他</option>
                            </select>
                            <span class="select-arrow" aria-hidden="true"></span>
                        </div>
                </div>
                @error('category_id')
                    <div class="select__error">{{ $message }}</div>
                @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせ内容</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--textarea">
                        <textarea name="detail" placeholder="資料をいただきたいです" >{{ old('detail') }}</textarea>
                        @error('detail')
                            <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">確認画面</button>
            </div>
        </form>
    </div>
@endsection