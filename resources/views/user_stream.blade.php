@extends('layouts.app')

@section('content')
<script src="{{ asset('js/user_stream.js') }}"></script>
<link href="{{ asset('css/user_stream.css') }}" rel="stylesheet">

<script>
    const YOUR_USER_ID = {{ auth()->user()->id }};
    const CLEAR_ROUTE_URL = "{{ route('clear') }}";
    const YOUR_CURRICULUM_ID = @json($filteredCurriculum->id ?? null);
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<h1>{{ $filteredCurriculum->title }}</h1><!-- タイトル名 -->
<h2>{{ $filteredCurriculum->description }}</h2>
<div class="grade">{{ $filteredCurriculum->grade_id }}</div><!-- 学年ID表示 -->

<h3>講座内容</h3>
<div class="return">
    <a href="{{ route('top') }}">←戻る</a>
</div>

<div class="media-container">
    @if($isWithinDeliveryPeriod || $filteredCurriculum->always_delivery_flg == 1)
        @php
            $videoId = '';
            if (preg_match('/v=([^&]+)/', $filteredCurriculum->video_url, $matches)) {
                $videoId = $matches[1];
            }
        @endphp
        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
        <img src="{{ asset('img/' . $filteredCurriculum->thumbnail) }}" alt="サムネイル" class="thumbnail">
    @endif
</div>

@if($canAttend)
    <form id="clearForm" action="{{ route('clear') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="curriculum_id" value="{{ $filteredCurriculum->id }}">
        <button type="submit" class="clear">受講する</button>
    </form>
@elseif($isCompleted)
    <button class="cleardone" disabled>受講済み</button>
@else
    <button class="no-clear" disabled>受講期間外</button>
@endif

@endsection
