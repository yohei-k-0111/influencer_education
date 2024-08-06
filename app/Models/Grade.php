<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // user（子）とのリレーション
    public function users()
    {
        return $this->hasMany(User::class);
    }
    // curriculums（子）とのリレーション
    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }
    // user（子）とのリレーション
    public function checks()
    {
        return $this->hasMany(ClassesClearCheck::class);
    }
}
