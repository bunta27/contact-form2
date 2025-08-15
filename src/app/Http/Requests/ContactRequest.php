<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * Get the valicd dation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['bail','required','string','max:255'],
            'last_name' => ['bail','required','string','max:255'],
            'gender' => ['bail','required', 'in:male,female,other'],
            'email' => ['bail','required','string','email','max:255'],
            'tel1' => ['bail','required','numeric','digits_between:1,5'],
            'tel2' => ['bail','required','numeric','digits_between:1,5'],
            'tel3' => ['bail','required','numeric','digits_between:1,5'],
            'address' => ['bail','required','string','max:255'],
            'building' => ['bail','nullable','string','max:255'],
            'category_id' => ['bail','required','in:1,2,3,4,5'],
            'detail' => ['bail','required','string','max:120'],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attributeを入力してください',
            'string' => ':attributeを文字列で入力してください',
            'max' => ':attributeは:max文字以下で入力してください',
            'gender.required' => '性別を選択してください',
            'email' => ':attributeはメール形式で入力してください',
            'numeric' => ':attributeを半角数字で入力してください',
            'digits_between' => ':attributeを5桁までの数字で入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'first_name'    => '名',
            'last_name'     => '姓',
            'gender'        => '性別',
            'email'         => 'メールアドレス',
            'tel1'          => '電話番号',
            'tel2'          => '電話番号',
            'tel3'          => '電話番号',
            'address'       => '住所',
            'building'      => '建物名',
            'category_id'  => 'お問い合わせの種類',
            'detail'       => 'お問い合わせ内容',
        ];
    }
}
