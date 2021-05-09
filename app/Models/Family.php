<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    const GENDER_MEN = 'men';
    const GENDER_WOMEN = 'women';

    const FIELD_MAP = [
        self::GENDER_MEN => '男',
        self::GENDER_WOMEN => '女',
    ];

    protected $table = 'family';
    public $timestamps = false;

    protected $fillable = [
        'name', 'gender', 'birthday', 'father_id', 'mother_id',
    ];
}
