@extends('admin.layouts.app')

@section('content')
<div class="main-outline">
<div class="button--return">
        <!-- 管理トップ画面へ戻るボタン -->
        <a href="{{ url('admin/top') }}">{{ "←戻る" }}</a>
    </div>
    <div class="main-content">
        <div class="main-content--header">
            <!-- 画面タイトル -->
            <h1 class="main-content--header__display-title">授業一覧</h1>
            <div class="main-content--header__middle">
                <div class="main-content--header__create-button">
                    <!-- 授業新規登録画面へ遷移（選択中の学年idも送信） -->
                    <a id="buttonCreate" class="list-button" href="{{ route('admin.show.curriculum.create', $select_grade->id) }}">新規登録</a>
                </div>
                <div id="replaceGrade">
                    <!-- 選択中の学年名を表示 -->
                    <h2 class="main-content--header__select-grade" data-grade_id="{{ $select_grade->id }}">{{ $select_grade->name }}</h2>
                </div>
            </div>
            <div class="main-content--header__flash-message">
                <!-- フラッシュメッセージ（授業登録・授業更新・配信登録） -->
                @if(session('store_curriculum_message'))
                <div>
                    {{ session('store_curriculum_message') }}
                </div>
                @endif
                @if(session('update_curriculum_message'))
                <div>
                    {{ session('update_curriculum_message') }}
                </div>
                @endif
                @if(session('upsert_delivery_message'))
                <div>
                    {{ session('upsert_delivery_message') }}
                </div>
                @endif
            </div>
        </div>
        <div class="main-content--body">
            <div class="main-content--body__grades">
                <!-- 学年選択ボタン列 -->
                @foreach ($grades as $grade)
                <form action="{{ route('admin.show.curriculum.list') }}" method="GET">
                    <button class="grade-select--button" type="button" name="grade_id" value="{{ $grade->id }}">{{ $grade->name }}</button><br>
                </form>
                @endforeach
            </div>
            <div id="replaceList" class="main-content--body__curriculums">
                <!-- 選択中学年の授業一覧を表示 -->
                @foreach ($curriculums as $curriculum)
                <div class="curriculum-content--outline">
                    <ul class="curriculum-content">
                        <li class="curriculum-content__thumbnail">
                            <!-- サムネイルが未登録の場合、NoImage用を表示 -->
                            <img class="img--list" src="{{ asset($curriculum->thumbnail) }}" alt="{{ $curriculum->thumbnail }}" onerror="altThumbnailImage(this);">
                        </li>
                        <li class="curriculum-content__title">【授業名】{{ $curriculum->title }}</li>

                        <li class="curriculum-content__delivery">
                            <!-- 配信日時一覧 -->
                            @if($curriculum->always_delivery_flg == 1)
                            <p>{{ "【常時公開】" }}</p>
                            @elseif($curriculum->deliveryTimes->isNotEmpty())
                            <table>
                                @foreach ($curriculum->deliveryTimes as $delivery_time)
                                <tr class="curriculum-content__delivery-item">
                                    <!-- 配信日時はここでは表示のみのためview側でフォーマットする -->
                                    <td>{{ \Carbon\Carbon::parse($delivery_time->delivery_from)->format('m月d日 H:i') }}</td>
                                    <td>〜</td>
                                    <td>{{ \Carbon\Carbon::parse($delivery_time->delivery_to)->format('m月d日 H:i') }}</td>
                                </tr>
                                @endforeach
                            </table>
                            @else
                            <p>{{ "【配信日時 未設定】" }}</p>
                            @endif
                        </li>
                        <li class="curriculum-content__button">
                            <!-- 「授業内容編集」ボタン・「配信日時編集」ボタン -->
                            <a class="list-button content-button" href="{{ route('admin.show.curriculum.edit', $curriculum->id) }}">{{ "授業内容編集" }}</a>
                            <a class="list-button content-button" href="{{ route('admin.show.delivery.edit', $curriculum->id) }}">{{ "配信日時編集" }}</a>
                        </li>
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    // 学年選択ボタン・選択中の学年表示の背景色指定（小学校はデフォルト）
    $(function(){
            // 中学校にスタイルを適用
            $('.grade-select--button').eq(6).addClass('jr-high-school');
            $('.grade-select--button').eq(7).addClass('jr-high-school');
            $('.grade-select--button').eq(8).addClass('jr-high-school');
            // 高校にスタイルを適用
            $('.grade-select--button').eq(9).addClass('high-school');
            $('.grade-select--button').eq(10).addClass('high-school');
            $('.grade-select--button').eq(11).addClass('high-school');
        });

    // サムネイル画像が存在しない場合、NoImage用画像を表示させる。※可能であればapp.blade.phpに書く
    function altThumbnailImage(img) {
        img.onerror = null; // 無限ループを防ぐ（imageタグを再読み込みするため）
        img.src = "{{ asset('storage/images/thumbnail/noimage/noimage.jpg') }}"; // NoImage用サムネイルファイルを指定
        img.alt = "{{ 'noimage.jpg' }}"; // NoImage用サムネイルファイルを指定
    }

    // 非同期処理開始
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content")},
    })
    $(function() {
        // 【非同期処理】学年ごと授業一覧切り替え
        $('.grade-select--button').on('click', function() {

            var select_grade_id = $(this).val(); // 学年選択ボタンを押下時のvalue
            console.log("選択した学年id："+select_grade_id);

            $.ajax({
                url: "{{ route('admin.show.curriculum.list') }}", //リクエスト先のurl
                method: "GET", //送信方式
                dataType: "html", // データ形式
                data: {
                    'grade_id' : select_grade_id,
                    '_token' : "{{ csrf_token() }}",
                }, //サーバーに送るデータ：一覧表示したい学年id、csrfトークン

            }).done(function(response) {
                // controllerから返ってきたデータの処理
                console.log("データ受け取り成功"); //サーバーからのデータ受け取り成功確認
                // console.log(response); //返ってきた授業一覧画面のデータ全体

                var replace_grade = $(response).find("#replaceGrade"); //選択した学年名
                var replace_curriculums = $(response).find("#replaceList"); //選択した部分の授業一覧
                var replace_buttonCreate = $(response).find("#buttonCreate"); //新規登録ボタン
                var replace_flash_message = $(response).find(".main-content--header__flash-message"); //フラッシュメッセージ
                console.log("表示する学年名："+replace_grade.text());
                // console.log(replace_curriculums);

                // 授業一覧の置換
                $("#replaceList").replaceWith(replace_curriculums);
                // 新規登録ボタンの置換（送信する学年idを更新するため）
                $("#buttonCreate").replaceWith(replace_buttonCreate);
                // 選択中の学年名の置換
                $("#replaceGrade").replaceWith(replace_grade);
                // フラッシュメッセージ部分の置換（＝削除）
                $(".main-content--header__flash-message").replaceWith(replace_flash_message);

                // 選択中の学年アイコンにスタイルを適用
                var display_grade = $(document).find('.main-content--header__select-grade');
                var display_grade_id = $(display_grade).data('grade_id');
                // 7-9:中学校 10-12:高校 小学校(1−6)はデフォルト
                if(display_grade_id >= 7) {
                    if(display_grade_id < 10) {
                        console.log(display_grade.html());
                        $(display_grade).addClass('jr-high-school');
                    }else{
                        $(display_grade).addClass('high-school');
                    }
                }

            }).fail(function() {
                // controllerから値が返ってこない場合の処理
                console.log("データ受け取り失敗");
                alert('通信が失敗しました'); //失敗時の警告表示
            });
        });
    });
</script>
@endsection
