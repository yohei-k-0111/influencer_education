<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Article extends Model
{
    use Hasfactory, Notifiable;

    protected $fillable = [
        'title',
        'posted_date',
        'article_contents'
    ];

    public static function getArticle()
    {
        // 記事を取得する処理をここに記述
        return self::orderBy('created_at', 'desc')->get();
    }
}