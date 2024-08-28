@extends('user.layouts.app')
@section('title', 'お知らせ')
@section('content')
<section class="wrapper">
    <div>
        <a href="{{ route('user.show.top') }}" class="arrow">戻る</a>
    </div>
    <div class="user-article">
        <p>{{ $date }}</p>
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->article_contents }}</p>
    </div>
</section>
@endsection