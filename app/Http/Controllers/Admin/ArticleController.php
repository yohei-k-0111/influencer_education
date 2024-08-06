<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
public function showArticleList()
{
    return view('admin.article_list');
}

public function showArticleCreate()
{
    return view('admin.article_create');
}
}
