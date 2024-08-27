<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassesClearCheck extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'users_id',
        'grade_id',
        'clear_flg',
    ];


    // テーブル名を明示的に指定
    protected $table = 'classes_clear_checks';

    

    // user（親）とのリレーション
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    // grade（親）とのリレーション
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
