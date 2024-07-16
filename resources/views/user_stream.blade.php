@extends('layouts.app')

@section('content')
<script src="{{ asset('js/user_stream.js') }}"></script>
<link href="{{ asset('css/user_stream.css') }}" rel="stylesheet">

<script>
    const YOUR_USER_ID = {{ auth()->user()->id }};
    const CLEAR_ROUTE_URL = "{{ route('clear') }}";
    const YOUR_CURRICULUM_ID = @json($curriculums->isEmpty() ? null : $curriculums->first()->id);
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

@if($curriculums->isEmpty())
    <div class="return"><a href="{{ route('top') }}">←戻る</a></div>
    <button class="delete">受講しました</button>    
    <img src="{{ asset('img/test.jpeg') }}" alt="サムネイル">
    @foreach($curriculums as $curriculum)
    <h1>{{ $curriculum->title }}</h1>
    @endforeach
@else
    @foreach($curriculums as $curriculum)
        <h1>{{ $curriculum->title }}</h1><!-- タイトル名 -->
        <h2>{{ $curriculum->description }}</h2>
        <div class="grade">{{ $curriculum->grade_id }}</div><!-- 学年ID表示 -->
    @endforeach

    <h3>講座内容</h3>
    <div class="return">
        <a href="{{ route('top') }}">←戻る</a>
    </div>

    <div class="video-container"> <!-- 期間を設けて動画を表示 -->
        @foreach ($curriculums as $curriculum)
            @if($curriculum->always_delivery_flg == 1)
                @php
                    $videoId = '';
                    if (preg_match('/v=([^&]+)/', $curriculum->video_url, $matches)) {
                        $videoId = $matches[1];
                    }
                @endphp
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            @else         
            @endif
        @endforeach
    </div>

    <form id="clearForm" action="{{ route('clear') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="curriculum_id" value="{{ !$curriculums->isEmpty() ? $curriculums->first()->id : '' }}">
        <button type="submit" class="clear">受講しました</button>
    </form>
@endif
@endsection
