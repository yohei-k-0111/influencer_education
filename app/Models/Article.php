<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'posted_date', 
        'article_contents'
    ];

    // ミューテータ
    public function setArticleContentAttribute($value)
    {
        $this->attributes['article_contents'] = $value;
    }

    // アクセサ
    public function getArticleContentAttribute()
    {
        return $this->attributes['article_contents'];
    }

    public function registArticle($data) {
        $this->title = $data->input('title');
        $this->posted_date = $data->input('posted_date');
        $this->article_contents = $data->input('article_content');
        $this->save();
    }
}
