<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    protected $table = 'delivery_times';

    // 期間設定のためにfillableプロパティを追加
    protected $fillable = [
        'curriculums_id',
        'delivery_from',
        'delivery_to'
    ];

    // 日付としてキャストするフィールドを指定
    protected $dates = [
        'delivery_from',
        'delivery_to',
    ];

    // カリキュラムとのリレーション
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }
}


