@extends('user.layouts.app')
@section('title', 'パスワード変更')
@section('content')

<section class="wrapper passwpord-wrapper">
    <h1>パスワード変更</h1>
    <form id="passwordForm" action="{{ route('user.password.temp_save') }}" method="POST">
        @csrf
        <input type="hidden" name="name" value="{{ old('name') }}">
        <input type="hidden"  name="name_kana" value="{{ old('name_kana') }}">
        <input type="hidden"  name="email" value="{{ old('email') }}">
            <div class="edit-password">
                <div class="user-item">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" value="{{ $tempPassword ?? '' }}">
                    @if($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="user-item">
                    <label for="password_confirmation">確認用パスワード</label>
                    <input type="password" name="password_confirmation" value="{{ $tempPassword ?? '' }}">
                    @if($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="profile-register">
                    <button type="submit" name='back' value="back" class="temporback-button">前に戻る</button>
                </div>
            </div>
    </form>

</section>

@endsection