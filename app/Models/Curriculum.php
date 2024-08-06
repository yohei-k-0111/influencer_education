<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    // 明示的にテーブル名を指定
    protected $table = 'curriculums';
    
    // grade（親）とのリレーション
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    // curriculum_progress（子）とのリレーション
    public function progresses()
    {
        return $this->hasMany(CurriculumProgress::class);
    }
    // delivery_times（子）とのリレーション
    public function deliveryTimes()
    {
        return $this->hasMany(deliveryTime::class);
    }
}
