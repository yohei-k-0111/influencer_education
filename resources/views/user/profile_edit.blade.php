@extends('user.layouts.app')
@section('title', 'プロフィール変更')
@section('content')


<section>
    <div>
        <a href="{{ route('user.show.top') }}">戻る</a>
    </div>
</section>
<section>
<!-- フラッシュメッセージ -->
<!-- パスワード一時保存時 -->
@if (session('message'))
    <script>
        $(function(){
            toastr.success('{{ session('message') }}');
        });
    </script>
@endif
<!-- プロフィール変更成功時 -->
@if(session('flash_message'))
    <script>
        $(function(){
            toastr.success('{{ session('flash_message') }}');
        });
    </script>
<!-- プロフィール変更失敗時 -->
@else
    <script>
        $(function(){
            toastr.danger('{{ session('error') }}');
        });
    </script>
@endif
    <h1>プロフィール変更</h1>
    <form action="{{ route('user.button.rooting') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="form_method" value="POST">

        <div>
            <label for="profile_image">プロフィール画像</label>
            @if($user->profile_image)
                <img src="{{ asset('storage/'.$user->profile_image) }}" width="100" alt="プロフィール画像">
            @else
                <img src="{{ asset('storage/noimage.jpeg') }}" width="100" alt="プロフィール画像">
            @endif
            <label for="profile_image"  name="profile_image" class="custom-upload">ファイルを選択</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control" value="{{ old('profile_image', $user->profile_image) }}">
        </div>
    <div>
        <label for="name">ユーザーネーム</label>
        <!-- <input type="text" name="name" value="{{ old('name', $user->name) }}"> -->
        <input type="text" name="name" value="{{ old('name', session('temp_profile_data.name', $user->name)) }}">
        @if($errors->has('name'))
            <p class="text-danger">{{ $errors->first('name') }}</p>
        @endif
    </div>
    <div>
        <label for="name_kana">カナ</label>
        <input type="text"  name="name_kana" value="{{ old('name_kana', session('temp_profile_data.name_kana', $user->name_kana)) }}">
        @if($errors->has('name_kana'))
            <p class="text-danger">{{ $errors->first('name_kana') }}</p>
        @endif
    </div>
    <div>
        <label for="email">メールアドレス</label>
        <input type="email"  name="email" value="{{ old('email', session('temp_profile_data.email', $user->email)) }}">
        @if($errors->has('email'))
            <p class="text-danger">{{ $errors->first('email') }}</p>
        @endif
    </div>
    <div>
        <label>パスワード</label>
        <input type="hidden" name="password" value="{{ session('temp_password') }}">
        <button type="submit" name="action" value="password_edit" onclick="setMethod('POST')">パスワードを変更する</button>
    </div>
    <button type="submit" name="action" value="profile_register" onclick="setMethod('PUT')">登録</button>
</form>

</section>

@endsection

