<?php

namespace App\Http\Controllers\User;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
public function showTop()
{
    $articles = Article::all();
    return view('user.top', compact('articles'));
}
}
