@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div>
                    <!-- 管理トップ画面へ戻るボタン -->
                    <a href="{{ url('admin/top') }}">{{ "←戻る" }}</a>
                </div>
                <!-- 画面タイトル -->
                <h1>授業一覧</h1>
                <div>
                    <!-- 授業新規登録画面へ遷移 -->
                    <a href="{{ route('admin.show.curriculum.create') }}">新規登録</a>
                </div>
                <div id="replaceGrade">
                    <!-- 選択中の学年を表示 -->
                    <h2>{{ $select_grade_name }}</h2>
                </div>
                <div>
                    <!-- 学年選択ボタン列 -->
                    @foreach ($grades as $grade)
                    <form action="{{ route('admin.show.curriculum.list') }}" method="GET">
                        <button class="selectGradeBtn" type="button" name="grade_id" value="{{ $grade->id }}">{{ $grade->name }}</button><br><br>
                    </form>
                    @endforeach
                </div id="flashMessageBox">
                    <!-- フラッシュメッセージ（授業登録・更新） -->
                    @if(session('store_curriculum_message'))
                    <div id="storeCurMsg">
                        {{ session('store_curriculum_message') }}
                    </div>
                    @endif
                    @if(session('update_curriculum_message'))
                    <div id="updateCurMsg">
                        {{ session('update_curriculum_message') }}
                    </div>
                    @endif
                <div>
                    <!-- 選択中学年の授業一覧を表示 -->
                    <div>
                        <ul id="replaceList">
                            @foreach ($curriculums as $curriculum)
                            <li>【授業id】{{ $curriculum->id }}</li>
                            <li>【学年id】{{ $curriculum->grade_id }}</li>
                            <li>
                                <!-- サムネイルが未登録の場合、NoImage用を表示 -->
                                <img src="{{ asset($curriculum->thumbnail) }}" alt="{{ $curriculum->thumbnail }}" width="80px" onerror="altThumbnailImage(this);">
                            </li>
                            <li>【授業名】{{ $curriculum->title }}</li>
                        
                            <li>
                                <!-- 配信日時一覧 -->
                                @if($curriculum->always_delivery_flg == 1)
                                <p>{{ "常時公開" }}</p>
                                @elseif($curriculum->deliveryTimes->isNotEmpty())
                                <table>
                                    @foreach ($curriculum->deliveryTimes as $delivery_time)
                                    <tr>
                                        <th class="delivery-item">【配信id】{{ $delivery_time->id }}</th>
                                        <td class="delivery-item">【授業id】{{ $delivery_time->curriculums_id }}</th>
                                        <!-- 配信日時はここでは表示のみのためview側でフォーマットする -->
                                        <td class="delivery-item">{{ \Carbon\Carbon::parse($delivery_time->delivery_from)->format('m月d日 H:i') }}</td>
                                        <td>〜</td>
                                        <td class="delivery-item">{{ \Carbon\Carbon::parse($delivery_time->delivery_to)->format('m月d日 H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                @else
                                <p>{{ "配信日時 未設定" }}</p>
                                @endif
                            </li>
                            <li>
                                <!-- 「授業内容編集」ボタン・「配信日時編集」ボタン -->
                                <a href="{{ route('admin.show.curriculum.edit', $curriculum->id) }}">{{ "授業内容編集" }}</a>
                                <a href="{{ route('admin.show.delivery.edit', $curriculum->id) }}">{{ "配信日時編集" }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

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
        $('.selectGradeBtn').on('click', function() {

            var select_grade_id = $(this).val(); // 学年選択ボタンを押下時のvalue
            console.log("選択した学年："+select_grade_id);

            $.ajax({

                url: "{{ route('admin.show.curriculum.list') }}", //リクエスト先のurl
                method: "GET", //送信方式
                dataType: "html", // データ形式
                data: {
                    'grade_id' : select_grade_id,
                }, //サーバーに送るデータ：一覧表示したい学年id

            }).done(function(response) {
                // controllerから返ってきたデータの処理
                console.log("データ受け取り成功"); //サーバーからのデータ受け取り成功確認
                // console.log(response); //返ってきた授業一覧画面のデータ全体

                var replace_grade = $(response).find("#replaceGrade"); //選択した学年名
                var replace_curriculums = $(response).find("#replaceList"); //選択した部分の授業一覧
                console.log("表示する学年名："+replace_grade);
                // console.log(replace_curriculums);

                // 選択中の学年名の置換
                $("#replaceGrade").replaceWith(replace_grade);
                // 授業一覧の置換
                $("#replaceList").replaceWith(replace_curriculums);

            }).fail(function() {
                // controllerから値が返ってこない場合の処理
                console.log("データ受け取り失敗");
                alert('通信が失敗しました'); //失敗時の警告表示
            });
        });
    });
</script>
@endsection
