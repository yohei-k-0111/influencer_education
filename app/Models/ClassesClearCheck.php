<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassesClearCheck extends Model
{
    use HasFactory;

    // grade（親）とのリレーション
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    // user（親）とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
