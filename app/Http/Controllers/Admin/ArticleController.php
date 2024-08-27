<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
public function showArticleList()
{
    $articles = Article::orderBy('posted_date', 'desc')->paginate(10);
    
    // ->map(function ($article) {
    // $articles = Article::orderBy('posted_date', 'desc')->get()->map(function ($article) {
    $articles->getCollection()->transform(function($article) {
        $article->formatted_date = Carbon::createFromFormat('Y-m-d H:i:s', $article->posted_date)->format('Y年n月j日');
            return $article;
    });
        // dd($dates);
    return view('admin.article_list', compact('articles'));
}

public function buttonRooting(Request $request)
{
    $articleID = $request->input('article_id');
    $article = $articleID ? Article::find($articleID) : null;

    // dd($articleID);
    if ($article) {
        return view('admin.article_create', compact('article'));
    }
    return view('admin.article_create');
}

public function articleCreate()
{

}

public function store(ArticleRequest $request)
{
    // dd($request->all());
    DB::beginTransaction();
    try {
        $article = new Article();
        $article->registArticle($request);
        DB::commit();
        return redirect()->route('admin.show.article.list')->with('article_message', '投稿を作成しました。');
        // return redirect()->route('admin.show.article.list')->with('message', '投稿を作成しました。');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('投稿の作成に失敗しました: ' . $e->getMessage());
        return back()->with('error', '投稿の作成に失敗しました。');
    }
}

public function update(ArticleRequest $request, $id)
{
    DB::beginTransaction();
    try {
        $article = Article::findOrFail($id);
        $article->registArticle($request);
        DB::commit();
        return redirect()->route('admin.show.article.list')->with('article_message', '投稿を更新しました。');
    } catch(\Exception $e) {
        DB::rollBack();
        return back()->with('error', '投稿の更新に失敗しました。');
    }
}

public function destroy(Request $request)
{    
    $articleId = $request->input('article_id');
    $article = Article::find($articleId);
    
    if ($article) {
        $article->delete();
        return response()->json(['success' => '投稿を削除しました。']);
    }
    
    return response()->json(['error' => '投稿が見つかりませんでした。'], 404);
}
   
    
}
