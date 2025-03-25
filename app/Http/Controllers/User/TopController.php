<?php

namespace App\Http\Controllers\User;

use App\Models\Article;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
public function showTop()
{
    $articles = Article::orderBy('posted_date', 'desc')->get()->map(function ($article) {
    // $articles = Article::all();
        $article->formatted_date = Carbon::createFromFormat('Y-m-d H:i:s', $article->posted_date)->format('Y年n月j日');
        return $article;
    });
    return view('user.top', compact('articles'));
}
}
