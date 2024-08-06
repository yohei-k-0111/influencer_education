<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    use HasFactory;

    // user（親）とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    // curriculum（親）とのリレーション
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
