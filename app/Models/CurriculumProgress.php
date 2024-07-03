<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curriculum;
use App\Models\User; // Userモデルが存在する場合
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculums_id',
        'users_id',
        'clear_flg',
    ];

    protected $table = 'curriculum_progress';

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public $timestamps = true;
}
