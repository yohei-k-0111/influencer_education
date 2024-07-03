@extends('layouts.app1')



<link href="{{ asset('css/user_login.css') }}" rel="stylesheet">

@section('content')

<div class="container" style="position: relative;">
    <a href="{{ route('register') }}" class="top-right-link" style="position: absolute; top: 0; right: 0;">{{ __('新規登録はこちら')}}</a>
</div>

<div class="container">
    <div class="card-header top" style="position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); width: 100%; text-align: center;">
        <div class="card-header top" style="position: absolute; top: -30%;right: 35%; font-size: 40px;">ログイン</div>
        <br>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-warning">
                                    {{ __('ログイン') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection