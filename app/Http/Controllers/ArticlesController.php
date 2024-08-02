<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Banner;

class ArticlesController extends Controller
{
    public function top(Request $request)
    {
        // デフォルトのソート条件を設定
        $sortColumn = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');

        // ページネーションを使用して記事を取得
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        
        //画像表示
        $banners = Banner::all();
        
        // AJAXリクエストの場合は部分ビューを返す
        if ($request->ajax()) {
            return view('article.show', compact('articles'))->render();
        }

        return view('top', compact('banners', 'articles'));
    }
    
    //仮ページ
    public function show($id)
    {
        // IDに基づいて記事を取得
        $articles = Article::findOrFail($id);

        // 記事をビューに渡して表示
        return view('articles.show', compact('articles'));
    }
}
