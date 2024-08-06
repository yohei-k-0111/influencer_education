@extends('user.layouts.app')
@section('title', 'お知らせ')
@section('content')
<section>
    <div>
        <a href="#">戻る</a>
    </div>
</section>
<section>
    <p>{{ $date }}</p>
    <h1>{{ $article->title }}</h1>
    <p>{{ $article->article_contents }}</p>
</section>

@endsection