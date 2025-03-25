@extends('user.layouts.app')
@section('title', 'プロフィール変更')
@section('content')

<section class="wrapper">
    <div>
        <a href="{{ route('user.show.top') }}" class="arrow">戻る</a>
    </div>
    <div>
        <!-- フラッシュメッセージ -->
        <!-- パスワード一時保存時 -->
        @if (session('password_message'))
        <meta name="success-message" content="{{ session('password_message') }}">
        @endif
        <!-- プロフィール変更成功時 -->
        @if (session('profile_message'))
        <meta name="success-message" content="{{ session('profile_message') }}">
        @endif
        <!-- プロフィール変更失敗時 -->
        @if (session('error'))
        <meta name="error-message" content="{{ session('error') }}">
        @endif
    </div>
    <div>
        <h1>プロフィール変更</h1>

        <div class="edit-profile">
            <form action="{{ route('user.button.rooting') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="profile_image">
                    @if($user->profile_image)
                    <img src="{{ asset($user->profile_image) }}" width="100" alt="profile image">
                    @else
                    <img src="{{ asset('storage/noimage.jpeg') }}" width="100" alt="profile image">
                    @endif
                    <div class="profile">
                        <div class="image-title">プロフィール画像</div>
                        <label for="profile_image" name="profile_image" class="custom-upload">ファイルを選択</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">
                    </div>
                </div>
                <div class="edit-items">
                    <div class="user-item">
                        <label for="name">ユーザーネーム</label>
                        <input type="text" name="name" value="{{ old('name', session('temp_profile_data.name', $user->name)) }}">
                    </div>
                    @if($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                    @endif
                    <div class="user-item">
                        <label for="name_kana">カナ</label>
                        <input type="text"  name="name_kana" value="{{ old('name_kana', session('temp_profile_data.name_kana', $user->name_kana)) }}">
                    </div>
                    @if($errors->has('name_kana'))
                    <p class="text-danger">{{ $errors->first('name_kana') }}</p>
                    @endif
                    <div class="user-item">
                        <label for="email">メールアドレス</label>
                        <input type="email"  name="email" value="{{ old('email', session('temp_profile_data.email', $user->email)) }}">
                    </div>
                    @if($errors->has('email'))
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                    @endif
                    <div class="user-item">
                        <label>パスワード</label>
                        <input type="hidden" name="new_password" value="{{ session('temp_profile_data.new_password') }}">
                        <button type="submit" name="action" value="password_edit" class="password">パスワードを変更する</button>
                    </div>
                    <div class="profile-register">
                        @method('PUT')
                        <button type="submit" name="action" value="profile_register" class="register-button">登録</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

