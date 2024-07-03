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
    @if(isset($data))
    @foreach ($data as $item)
        <div class="card mb-3">
            <div class="card-body">
                <p>{{ $article->article_contents, 0, 100 }}</p>
                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary"></a>
            </div>
        </div>
    @endforeach
    @endif
</div>

@endsection
