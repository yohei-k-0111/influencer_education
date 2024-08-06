@extends('user.layouts.app')
@section('title', 'パスワード変更')
@section('content')
<section>
    
</section>
<section>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
    <h1>パスワード変更</h1>
    <form id="passwordForm" action="{{ route('user.password.temp_save') }}" method="POST">
        @csrf
        <input type="hidden" name="name" value="{{ old('name') }}">
        <input type="hidden"  name="name_kana" value="{{ old('name_kana') }}">
        <input type="hidden"  name="email" value="{{ old('email') }}">
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" value="{{ $tempPassword ?? '' }}">
            @if($errors->has('password'))
            <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div>
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" name="password_confirmation" value="{{ $tempPassword ?? '' }}">
            @if($errors->has('password'))
            <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif
        </div>
    <!-- <a href="{{ route('user.password.temp_save') }}">一時保存し戻る</a> -->
        <button type="submit" name='back' value="back">前に戻る</button>
    </form>

</section>

@endsection