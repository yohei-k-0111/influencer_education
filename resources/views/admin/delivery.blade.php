@extends('admin.layouts.app')

@section('content')
<div class="main-outline">
    <div class="main-content">
        <div class="main-content--header">
            <!-- 授業一覧画面へ戻るボタン -->
            <div class="button--return">
                <a href="{{ route('admin.show.curriculum.list') }}">{{ "←戻る" }}</a>
            </div>
            <!-- 画面タイトル -->
            <h1 class="main-content--header__display-title">配信日時設定</h1>
            <!-- 選択中の授業名 -->
            <h2 class="main-content--header__curriculum-title">{{ $curriculum->title }}</h2>
        </div>
        <div class="main-content--body">
            <!-- エラーメッセージ -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- 入力フォーム＆削除ボタン -->
            <div class="form--item form--item__delivery">
                <!-- 配信日時入力フォーム列 -->
                <!-- POST送信するvalue値を配列recordsに格納する -->
                <form id="deliveryForm" class="form form--item__column" action="{{ route('admin.show.delivery.upsert') }}" method="POST">
                    @csrf
                    <!-- 入力フォーム列 -->
                    <table id="deliveryFormRecords">
                        @if($record_count > 0)
                        <!-- 配信設定が存在する場合 -->
                        @foreach ($delivery_times as $index => $delivery_time)
                        <tr class="delivery--row__form" data-deliveryTimeId="{{ $delivery_time->id }}">
                            <td>
                                <input type="date" value="{{ $delivery_time->date_from }}" name="records[{{ $index }}][date_from]" placeholder="年月日">
                                <input type="time" value="{{ $delivery_time->time_from }}" name="records[{{ $index }}][time_from]" placeholder="時間">
                            </td>
                            <td class="delivery__wave-dash">〜</td>
                            <td>
                                <input type="date" value="{{ $delivery_time->date_to }}" name="records[{{ $index }}][date_to]" placeholder="年月日">
                                <input type="time" value="{{ $delivery_time->time_to }}" name="records[{{ $index }}][time_to]" placeholder="時間">
                            </td>
                        </tr>
                            <!-- hidden -->
                            <input type="hidden" value="{{ $delivery_time->id }}" name="records[{{ $index }}][id]">
                            <input type="hidden" value="{{ $delivery_time->curriculums_id }}" name="records[{{ $index }}][curriculums_id]">
                        @endforeach
                        <!-- 配信設定が存在しない場合は空行を1行表示 -->
                        @else
                        <tr class="delivery--row__form">
                            <td>
                                <input type="date" name="records[0][date_from]" placeholder="年月日">
                                <input type="time" name="records[0][time_from]" placeholder="時間">
                            </td>
                            <td class="delivery__wave-dash">〜</td>
                            <td>
                                <input type="date" name="records[0][date_to]" placeholder="年月日">
                                <input type="time" name="records[0][time_to]" placeholder="時間">
                            </td>
                        </tr>
                            <!-- hidden -->
                            <input type="hidden" name="records[0][id]">
                            <input type="hidden" name="records[0][curriculums_id]" value="{{ $id }}">
                        @endif
                    </table>
                    <!-- hidden -->
                    <input type="hidden" name="curriculums_id" value="{{ $id }}">
                    <br>
                    <div>
                        <!-- 行追加ボタン -->
                        <button class="delivery--button__add-record circle-button" type="button" id="addRecordBtn">{{ "＋" }}</button>
                    </div>
                    <br>
                    <div class="form--button">
                        <!-- 登録ボタン -->
                        <button class="form--button__tag form--button__delivery" id="deliveryBtnRegister" type="button">一括登録</button>
                    </div>
                </form>
                <div class="form--item__column"></div>
                <!-- 削除ボタン列 -->
                <table id="deliveryBtnRecords" class="form--item__column" >
                    @if($record_count > 0)
                    <!-- 配信設定が存在する場合 -->
                    @foreach ($delivery_times as $index => $delivery_time)
                        <tr class="delivery--row__delete" data-deliveryTimeId="{{ $delivery_time->id }}">
                            <td>
                                <form method="POST" class="delivery--form__delete" name="records[{{ $index }}][id]" action="{{ route('admin.show.delivery.destroy', $delivery_time->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="curriculums_id" value="{{ $delivery_time->curriculums_id }}">
                                    <!-- 削除ボタン -->
                                    <input class="delivery--button__delete circle-button" type="button" value="ー">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    <!-- 配信設定が存在しない場合は削除ボタンなし -->
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // 登録ボタン押下時ダイアログ
        $('#deliveryBtnRegister').click(function() {
            if(confirm('配信設定日時を登録・更新しますか？')) {
                $('#deliveryForm').submit();
            }else{
                return false;
            }
        });
    });

    // 行数の定義（行追加で使用）
    var record_count = {{ count($delivery_times) }} ;
    if(record_count == 0) {
        record_count = ++record_count;
    }

    $(function() {
        // 行追加（通常のjsイベント処理）
        $('#addRecordBtn').click(function() {

            // 追加入力フォーム
            const NEW_RECORD = `
                <tr class="add--row__form" data-hundleRecord="${record_count}">
                    <td>
                        <input type="date" name="records[${record_count}][date_from]" placeholder="年月日">
                        <input type="time" name="records[${record_count}][time_from]" placeholder="時間">
                    </td>
                    <td class="delivery__wave-dash">〜</td>
                    <td>
                        <input type="date" name="records[${record_count}][date_to]" placeholder="年月日">
                        <input type="time" name="records[${record_count}][time_to]" placeholder="時間">
                    </td>
                </tr>
                    <!-- hidden -->
                    <input type="hidden" name="records[${record_count}][id]">
                    <input type="hidden" name="records[${record_count}][curriculums_id]" value="{{ $id }}">
                `;
            // 追加削除ボタン
            const DLT_RECORD = `
                <tr class="add--row__delete" data-hundleRecord="${record_count}">
                    <td>
                        <button class="add--button__delete circle-button" type="button">{{ "ー" }}</button>
                    </td>
                </tr>
                `;

            // 行追加（入力フォーム＆削除ボタン）
            $('#deliveryFormRecords').append(NEW_RECORD);
            $('#deliveryBtnRecords').append(DLT_RECORD);
            // 追加分の record_count加算
            record_count = ++record_count;
            console.log("行追加後の行数：" + record_count);

            // 行削除イベントバインド ※追加行（DB未登録の行）下記定義①
            $(document).on('click', '.add--button__delete', deleteAddRecord);

        });

    });

    // 行削除定義① ※DB未登録の追加行
    function deleteAddRecord() {

        let add_click = $(this); // クリックしたthisレコード(要素)を指定
        let delete_add_button = add_click.parents('.add--row__delete'); //削除対象行のボタン要素
        let hundle_record_value = delete_add_button.attr('data-hundleRecord'); // 削除対象フォームに対応するキー値
        // 削除対象行のフォーム要素
        let delete_add_form = $('#deliveryFormRecords').find('tr[data-hundleRecord="' + hundle_record_value + '"]');

        console.log("追加行の削除：クリック");
        console.log("削除行の対応キー："+hundle_record_value);
        // 行削除（入力フォーム＆削除ボタン）
        delete_add_button.remove();
        delete_add_form.remove();
    }

    // 非同期処理開始
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content")},
    });

    @if($record_count > 0) // 配信設定が存在する場合
        $(function() {
            // 行削除イベントバインド ※DB登録済みの行 下記定義②
            $('.delivery--button__delete').on('click', deleteDeliveryRecord);
        });

        // 【非同期処理】行削除定義② ※DB登録済み行
        function deleteDeliveryRecord(e) {

            e.preventDefault(); //通常の処理を制御する

            // 削除確認モーダルを表示させる
            var delete_confirm = confirm('この配信設定を削除しますか？');

            if(delete_confirm == true) {
                //confirmで ”はい” を選択した場合、処理実行

                let this_click = $(this); // クリックしたthis要素
                let dlt_curriculums_id = this_click.siblings('input[name="curriculums_id"]').val(); // thisのcurriculums_id
                let delete_record_button = this_click.parents('.delivery--row__delete'); // 削除対象行のボタン要素
                let hundle_id_value = delete_record_button.attr('data-deliveryTimeId'); // 削除対象の配信日時id　※送信データを明確にするため、かつ対応するフォーム側要素を取得するため
                let delete_record_form = $('#deliveryFormRecords').find('tr[data-deliveryTimeId="' + hundle_id_value + '"]'); // 削除対象行のフォーム要素
                let delete_url = '/influencer_education/public/admin/delivery_destroy/' + hundle_id_value; // 正しいidを付与してリクエストするために送信url定義

                console.log("登録行 削除クリック");
                console.log("カリキュラムid:"+dlt_curriculums_id);
                console.log("配信日時id:"+hundle_id_value);
                console.log("送信url:"+delete_url);

                $.ajax({
                    url: delete_url, //リクエスト先のurl
                    method: "POST", //送信方式
                    dataType: "html", // データ形式
                    data: {
                        'curriculums_id' : '{{ $delivery_time->curriculums_id }}',
                        '_method' : 'DELETE'
                    }, //サーバーに送るデータ
                }).done(function(response) {
                    // controllerから値が返ってきた場合の処理
                    console.log("データ受け取り成功");
                    // 行削除（削除ボタン＆入力フォーム）
                    delete_record_button.remove();
                    delete_record_form.remove();

                }).fail(function(response) {
                    // controllerから値が返ってこない場合の処理
                    console.log("データ受け取り失敗");
                    alert('通信が失敗しました'); //失敗時の警告表示
                });
            } else {
                //confirmで ”いいえ” を選択した場合、キャンセル処理
                (function(e) {
                e.preventDefault()
                });
            }
        }
    @endif
</script>
@endsection
