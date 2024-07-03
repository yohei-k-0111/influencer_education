<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Banner;

class ArticlesController extends Controller
{
    public function top(Request $request)
    {
        $articles = Article::orderBy('article_contents', 'desc')->first();
        $banners = Banner::all();
        \Log::info('Articles:', ['articles' => $articles]);
        \Log::info('Banners:', ['banners' => $banners]); // toArray() を削除してログ出力
        
    
        return view('top', compact('banners', 'articles'));
    }

    public function sorted(Request $request)
    {
        $articles = Article::ovderBy('created_at', 'desc')->get();

        return response()->json($articles);
    }
}
