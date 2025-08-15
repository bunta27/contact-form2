<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $v = $request->validated();
        $request->session()->put('contact.input', $v);

        $genderLabel = ['male' => '男性', 'female' => '女性', 'other' => 'その他'];
        $typeLabel = [
            '1' => '商品のお届けについて',
            '2' => '商品の交換について',
            '3' => '商品トラブル',
            '4' => 'ショップへのお問い合わせ',
            '5' => 'その他',
        ];

        $contact = [
            'name'        => trim(($v['last_name']).' '.($v['first_name'])),
            'gender'      => $genderLabel[$v['gender']],
            'email'       => $v['email'],
            'tel'         => $v['tel1']. $v['tel2']. $v['tel3'],
            'address'     => $v['address'],
            'building'    => $v['building'] ?? '',
            'category_id' => $typeLabel[$v['category_id']],
            'detail'      => $v['detail'],
        ];
        return view('confirm', compact('contact'));
    }

    public function store()
    {
        $v = session()->pull('contact.input');
        abort_unless($v, 419, 'セッションが切れました。もう一度やり直してください。');

        Contact::create([
            'name'        => trim(($v['last_name']).' '.($v['first_name'])),
            'gender'      => $v['gender'],
            'email'       => $v['email'],
            'tel'         => $v['tel1']. $v['tel2']. $v['tel3'],
            'address'     => $v['address'],
            'building'    => $v['building'] ?? null,
            'category_id' => (int)$v['category_id'],
            'detail'      => $v['detail'],
        ]);

        return redirect()->route('contacts.thanks');
    }
}
