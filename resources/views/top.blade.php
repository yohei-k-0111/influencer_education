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
            <span class="dot {{$i == 1 ? 'active' : ''}}" onclick="changeImage({{$i}})"></span>
        @endfor
    </div>

    <button class="btn-1" id="btn1">●</button>
    <button class="btn-2" id="btn2">●</button>
</div>

<div class="container">
    <h1>お知らせ</h1>
    <div class="notice-list">
        @if(isset($articles))
            <div class="news-box">
                @foreach ($articles as $article)
                    <div class="news-item">
                        <a href="{{ route('articles.show', $article->id) }}" class="card-link">
                        <p>
                            {{ 
                                $article->posted_date 
                                ? \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d') 
                                : '' 
                            }}
                        </p>
                            <p>{{ Str::limit($article->article_contents, 100) }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{ $articles->links('pagination::bootstrap-4') }}

@endsection
