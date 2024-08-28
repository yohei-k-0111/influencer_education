@extends('user.layouts.app')
@section('title', 'インフルエンサー教育システム')
@section('content')
<section class="wrapper">
    <div>
        <a href="{{ route('user.show.top') }}" class="arrow">戻る</a>
    </div>

    <div class="user-profile">
        <div>
            @if($user->profile_image)
            <img src="{{ asset($user->profile_image) }}"  width="200" alt="profile image">
            @else
            <img src="{{ asset('storage/noimage.jpeg') }}" alt="profile image">
            @endif
        </div>
        <div class="user-info">
            <div>{{ $user->name }}さんの授業進捗</div>
            <div>現在の学年：
                <span class="user-grade">{{ $user->grade->name }}</span>
            </div>
        </div>
    </div>

    <div class="grade-container">
        <div class="grade-list"> 
           @foreach ($grades as $grade)
           <table>
               <thead>
                   <tr>
                       @php
                       $backgroundClass = '';
                       if (in_array($grade->id, [1, 2, 3])) {
                           $backgroundClass = 'lightblue-bg';
                        } elseif (in_array($grade->id, [4, 5, 6])) {
                            $backgroundClass = 'skyblue-bg';
                        } elseif (in_array($grade->id, [7, 8, 9])) {
                            $backgroundClass = 'lightgreen-bg';
                        } elseif (in_array($grade->id, [10, 11, 12])) {
                            $backgroundClass = 'green-bg';
                        }
                        @endphp
                        <th class="surround {{ $backgroundClass }}">{{ $grade->name }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grade->curriculums as $curriculum)
                    <tr>
                        <td>
                            @if (isset($curriculumProgresses[$curriculum->id]) && $curriculumProgresses[$curriculum->id]->clear_flg == 1)
                            <span class="comp">受講済</span>
                            @endif
                            @if ($grade->id <= $user->grade_id || (isset($clearCheck) && $clearCheck->grade_id == $grade->id && $clearCheck->clear_flg == 1))
                            <a class="curri-title" href="{{ $curriculum->video_url }}">{{ $curriculum->title }}</a>
                            @else
                            <a class="curri-title" href="#" tabindex="-1" style="pointer-events: none; color: grey;">{{ $curriculum->title }}</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endforeach
        </div>
    </div> 
</section>
@endsection
