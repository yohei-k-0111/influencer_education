@extends('user.layouts.app')
@section('title', 'インフルエンサー教育システム')
@section('content')
<section class="wrapper">
    <div>バナー画像</div>
    <h1>お知らせ</h1>
    <container>
        @foreach ($articles as $article)
        <p><a href="{{ route('user.show.article', ['id' => $article->id]) }}">{{ $article->posted_date }} {{ $article->title }}</a></p>
        @endforeach
    </container>
</section>
@endsection