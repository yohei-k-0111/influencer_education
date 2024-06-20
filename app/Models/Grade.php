<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curriculum;

class Grade extends Model
{
    use HasFactory; //ファクトリー使用なし

    // Curriculumモデルと「1対多」のリレーション関係を結ぶ
    public function curriculums() {
        return $this->hasMany(Curriculum::class);
    }
    
}
