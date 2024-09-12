@extends('user.layouts.app')
@section('title', 'パスワード変更')
@section('content')

<section class="wrapper passwpord-wrapper">
    <h1>パスワード変更</h1>
    <form id="passwordForm" action="{{ route('user.password.temp_save') }}" method="POST">
        @csrf
        <input type="hidden" name="name" value="{{ session('temp_profile_data.name', '') }}">
        <input type="hidden"  name="name_kana" value="{{ session('temp_profile_data.name_kana', '') }}">
        <input type="hidden"  name="email" value="{{ session('temp_profile_data.email', '') }}">
            <div class="edit-password">
                <div class="user-item">
                    <label for="current_password">現在のパスワード</label>
                    <input type="password" name="current_password">
                </div>
                @if($errors->has('current_password'))
                    <p class="text-danger">{{ $errors->first('current_password') }}</p>
                @endif
                <div class="user-item">
                    <label for="new_password">新しいパスワード</label>
                    <input type="password" name="new_password">
                </div>
                @if($errors->has('new_password'))
                <p class="text-danger">{{ $errors->first('new_password') }}</p>
                @endif
                <div class="user-item">
                    <label for="new_password_confirmation">新しいパスワード（確認用）</label>
                    <input type="password" name="new_password_confirmation">
                </div>
                @if($errors->has('new_password'))
                <p class="text-danger">{{ $errors->first('new_password') }}</p>
                @endif
                <div class="profile-register">
                    <button type="submit" class="update-button">パスワードを一時保存</button>
                    <a href="{{ route('user.show.profile') }}" class="back-button">戻る</a>
                </div>
            </div>
    </form>
</section>
@endsection