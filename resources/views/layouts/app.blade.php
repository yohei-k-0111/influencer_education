<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link href="{{ asset('css\user_app.css') }}"rel="stylesheet">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'influencer_eucation') }}</title>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="container">               
                <!-- 仮のリンク -->
                <a href="{{ route('jikanbu') }}"button class="header-button" >時間割</a>                       
                <a href="{{ route('lessons') }}"button class="header-button" >授業進捗</a>
                <a href="{{ route('profile-setting') }}"button class="header-button" >プロフィール設定</a>

                <div>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">ログアウト</button>
                    </form>
                    @csrf
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
