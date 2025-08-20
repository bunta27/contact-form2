<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'category_id',
        'detail',
    ];

    protected $appends = ['gender_label'];

    public function getGenderLabelAttribute(): string
    {
        $g = $this->gender;

        $map = [
            'male'   => '男性',
            'female' => '女性',
            'other'  => 'その他',
            '男性'   => '男性',
            '女性'   => '女性',
            'その他' => 'その他',
        ];

        return $map[$g] ?? (string) $g;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
