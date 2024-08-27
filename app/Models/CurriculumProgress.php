<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurriculumProgress extends Model
{
    use HasFactory;

    // user（親）とのリレーション
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    // curriculum（親）とのリレーション
    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }
}
