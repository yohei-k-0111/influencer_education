@extends('layouts.app')

@section('content')

<script src="{{ asset('js/user_top.js') }}"></script>
<link href="{{ asset('css/user_top.css') }}" rel="stylesheet">

<div id="header-container">
@foreach ($banners as $banner)
    <div class="banner">
        <img src="{{ asset('img/' . $banner->image) }}" alt="Banner Image">
    </div>
@endforeach

    <div id="dots">
        @for ($i = 1; $i <= 3; $i++)
            <span class="dot {{$i == 1? 'active' : ''}}" onclick="changeImage({{$i}})"></span>
        @endfor
    </div>

    <button class="btn-1" id="btn1">●</button>
    <button class="btn-2" id="btn2">●</button>
</div>

<div class="container">
    <h1>お知らせ</h1>
    <div class="notice-list">
    @if(isset($articles))
        @foreach ($articles as $article)
            <div class="card mb-3">
                <a href="{{ route('articles.show', $article->id) }}" class="card-link">
                    <div class="card-body">
                        <p>{{ Str::limit($article->article_contents, 100) }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>

@endsection
