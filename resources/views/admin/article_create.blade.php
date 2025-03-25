@extends('admin.layouts.app')
@section('title', isset($article) ? 'お知らせ変更' : 'お知らせ新規作成')
@section('content')
<section class="wrapper">
    <div>
        <a href="{{ route('admin.show.article.list') }}" class="arrow">戻る</a>
    </div>
    <div class="article-create">
        <h1>{{ isset($article) ? 'お知らせ変更' : 'お知らせ新規' }}</h1>
        <form action="{{ isset($article) ? route('admin.article.update', $article->id) : route('admin.article.store') }}" method="POST">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif
        <div class="create-item">
            <label>投稿日時</label>
                <input type="date" name="posted_date" value="{{ old('posted_date', isset($article) ? \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d') : '')}}">
            @if($errors->has('posted_date'))
            <p class="text-danger">{{ $errors->first('posted_date') }}</p>
            @endif
        </div>
        <div class="create-item">
            <label>タイトル</label>
                <input type="text" name="title" value="{{ old('title', $article->title ?? '')}}">                
            @if($errors->has('title'))
            <p class="text-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>
        <div class="create-item">
            <label>本文</label>
                <textarea name="article_content">{{ old('article_content', $article->article_content ?? '') }}</textarea>
            @if($errors->has('article_content'))
            <p class="text-danger">{{ $errors->first('article_content') }}</p>
            @endif
        </div>
        <div class="create-submit">
            <button type="submit" class="create-button">登録</button>
        </div>
        </form>
    </div>
</section>
@endsection