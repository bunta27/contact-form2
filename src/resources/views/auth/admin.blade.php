@extends('auth.layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('btn')
    <a class="header__btn" href="{{ route('login') }}">logout</a>
@endsection

@section('title')
    <h2 class="title">Admin</h2>
@endsection

@section('content')
<form action="" method="get" class="filters">
    <div class="filters__top">
        <input class="input input--q" name="q" value="{{ request('q') }}" placeholder="名前やメールアドレスを入力してください">
        <div class="select-wrap">
            <select class="select" name="gender" >
                <option value="">性別</option>
                <option value="male" @selected(request('gender')==='male')>男性</option>
                <option value="female" @selected(request('gender')==='female')>女性</option>
                <option value="other" @selected(request('gender')==='other')>その他</option>
            </select>
        </div>
        <div class="select-wrap">
            <select class="select" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"{{ (string)$cat->id === (string)request('category_id') ? 'selected' : '' }}>
                    {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="date-input s-w100">
        <input
            type="date"
            class="input input--date js-date"
            name="date"
            value="{{ request('date') }}"
            autocomplete="off">
        </div>

        <button class="btn btn--sr">
            検索
        </button>
        <a class="btn btn--ghost" href="{{ route('admin.contacts.index') }}">リセット</a>
    </div>
    <div class="filters__bottom">
        <a class="btn btn--ep" href="{{ route('admin.contacts.export', request()->query()) }}">エクスポート</a>

        <div class="filters__pager">
            {{ $contacts->onEachSide(1)->links('auth.pagination') }}
        </div>
    </div>
</form>

    <table class="list">
        <thead class="list_thead">
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="list__body">
            @foreach($contacts as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->gender_label }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ optional($c->category)->name }}</td>
                <td class="list__actions">
                    <button class="btn btn--sm" data-detail="{{ route('admin.contacts.show',$c) }}">詳細</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>

<div id="detailModal" class="modal" hidden>
    <div class="modal__panel">
        <button class="modal__close" aria-label="close">×</button>
        <dl class="detail">
            <div><dt>お名前</dt><dd id="d-name"></dd></div>
            <div><dt>性別</dt><dd id="d-gender"></dd></div>
            <div><dt>メールアドレス</dt><dd id="d-email"></dd></div>
            <div><dt>電話番号</dt><dd id="d-tel"></dd></div>
            <div><dt>住所</dt><dd id="d-address"></dd></div>
            <div><dt>建物名</dt><dd id="d-building"></dd></div>
            <div><dt>お問い合わせの種類</dt><dd id="d-type"></dd></div>
            <div><dt>お問い合わせ内容</dt><dd id="d-detail"></dd></div>
        </dl>
        <form id="deleteForm" class="inline" action="" method="post" onsubmit="return confirm('削除しますか？')">
            @csrf
            @method('DELETE')
            <button class="btn btn--danger" style="margin-top:16px;">削除</button>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('[data-detail]').forEach(btn => {
        btn.addEventListener('click', async () => {
        const res = await fetch(btn.dataset.detail);
        if (!res.ok) return;
        const d = await res.json();
        ['name','gender','email','tel','address','building','type','detail']
            .forEach(k => document.getElementById('d-'+k).textContent = d[k] ?? '');
        document.getElementById('deleteForm').action = "{{ url('/admin/contacts') }}/" + d.id;
        document.getElementById('detailModal').hidden = false;
        });
    });
    document.querySelector('#detailModal .modal__close').addEventListener('click', () => {
        document.getElementById('detailModal').hidden = true;
    });
    document.getElementById('detailModal').addEventListener('click', (e) => {
        if (e.target.id === 'detailModal') e.currentTarget.hidden = true;
    });

    document.querySelectorAll('.js-date').forEach(el => {
        const open = () => (typeof el.showPicker === 'function' ? el.showPicker() : el.focus());

    // クリック/フォーカスで即カレンダー表示
        el.addEventListener('click', open);
        el.addEventListener('focus', open);

    // 入力キーは基本すべてブロック（Tab/Escape/矢印だけ許可）
        el.addEventListener('keydown', e => {
        const ok = ['Tab','Escape','ArrowLeft','ArrowRight','ArrowUp','ArrowDown'];
        if (!ok.includes(e.key)) e.preventDefault();
        });
        el.addEventListener('beforeinput', e => e.preventDefault());

        // ラッパ（▼三角含む）クリックでも開く
        el.closest('.date-input')?.addEventListener('click', e => {
        if (e.target !== el) open();
        });

    document.querySelectorAll('.js-date').forEach(el => {
        const wrap = el.closest('.date-input');
        const sync = () => wrap && wrap.classList.toggle('has-value', !!el.value);
        sync();
        el.addEventListener('change', sync);
        el.addEventListener('input',  sync);
        });
    });
</script>

@endsection