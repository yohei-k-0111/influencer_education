<?php

namespace App\Http\Controllers\User;

use App\Models\Article;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // public function showArticle(Request $request)
    public function showArticle($id)
    {
        // $article = Article::findOrFail($id);
        $article = Article::find($id);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $article->posted_date)->format('Y年n月j日');

        return view('user.article', compact('article', 'date'));
    }
}
