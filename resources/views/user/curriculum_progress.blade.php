@extends('user.layouts.app')
@section('title', 'インフルエンサー教育システム')
@section('content')
<section>
    <div>
        <a href="#">戻る</a>
    </div>
</section>
<section>
    @auth

    @if($user->profile_image)
    <!-- <img src="{{ asset('storage/'.Auth::user()->profile_image) }}" alt="profile image"> -->
    <img src="{{ asset('storage/'.$user->profile_image) }}" alt="profile image">
    @else
    <img src="{{ asset('storage/noimage.jpeg') }}" alt="profile image">
    @endif
    <div>{{ $user->name }}さんの授業進捗</div>
    <div>現在の学年：
        <span>{{ $user->grade->name }}</span>
    </div>
    @endauth
</section>
<section>
    <div>
        <table>
            @foreach ($grades as $grade)
            <thead>
                <tr>
                    <th class="surround">{{ $grade->name }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grade->curriculums as $curriculum)
                @php
                        $progress = $user->curriculumProgresses->firstWhere('curriculum_id', $curriculum->id);
                    @endphp
                <tr>
                    <td>
                        @if ($progress && $progress->clear_flg == 1)
                        <span>受講済み</span>
                        @endif
                        <a href="{{ $curriculum->video_url }}">{{ $curriculum->title }}</a>
                        </td>
                        </tr>
                @endforeach
                        </tbody>
                    @endforeach
        </table>
    </div>
</section>
@endsection
