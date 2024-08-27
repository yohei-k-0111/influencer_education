<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;  //追加
use Illuminate\Notifications\Notifiable;  //追加
// use Illuminate\Database\Eloquent\Model;  コメントアウト

class Admin extends User  //追加
// class Admin extends Model  コメントアウト
{
    use HasFactory, Notifiable;  //追加
    // use HasFactory;  コメントアウト

    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
