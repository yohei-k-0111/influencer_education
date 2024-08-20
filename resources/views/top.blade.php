@extends('layouts.app')

@section('content')

<script src="{{ asset('js/user_top.js') }}"></script>
<link href="{{ asset('css/user_top.css') }}" rel="stylesheet">

<div id="header-container">
    @if($banners->count() > 0)
        @foreach ($banners as $index => $banner)
            <div class="banner {{ $index === 0 ? 'active' : '' }}" id="banner-{{ $index }}">
                <img src="{{ asset('img/' . $banner->image) }}" alt="Banner Image">
            </div>
        @endforeach

        <div id="dots">
            @foreach ($banners as $index => $banner)
                <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="changeImage({{ $index }})"></span>
            @endforeach
        </div>

        <div id="buttons-container">
            @for ($i = 0; $i < 3; $i++)
                <button class="btn-{{ $i + 1 }}" id="btn{{ $i + 1 }}">●</button>
            @endfor
        </div>
    @endif
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
