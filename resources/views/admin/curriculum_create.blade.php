@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div>
                    <!-- 授業一覧画面へ戻るボタン -->
                    <a href="{{ route('admin.show.curriculum.list') }}">{{ "←戻る" }}</a>
                </div>
                <!-- 画面タイトル -->
                <h1>{{ "新規授業登録" }}</h1>
                <div>
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
                    <!-- 入力フォーム -->
                    <form id="registCurriculumForm" action="{{ route('admin.show.curriculum.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <ul>
                            <li class="create-item">
                                <label for="crtThumbnail">{{ "サムネイル" }}</label>
                                <input type="file" name="thumbnail" id="crtThumbnail">
                            </li>
                            <li class="create-item">
                                <!-- 必須項目（学年） -->
                                <label for="crtGradeId">{{ "学年" }}</label>
                                <select name="grade_id" id="crtGradeId">
                                    @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="create-item">
                                <!-- 必須項目（授業名） -->
                                <label for="crtTitle">{{ "授業名" }}</label>
                                <input type="text" name="title" id="crtTitle">
                            </li>
                            <li class="create-item">
                                <label for="crtVideoUrl">{{ "動画URL" }}</label>
                                <input type="url" name="video_url" id="crtVideoUrl">
                            </li>
                            <li class="create-item">
                                <label for="crtDescription">{{ "授業概要" }}</label>
                                <input type="textarea" name="description" id="crtDescription">
                            </li>
                            <li class="create-item">
                                <!-- 常時公開チェックがONであればvalue=1, OFFであればvalue=0 を送信 -->
                                <input type="hidden" name="always_delivery_flg" value="0" >
                                <input type="checkbox" name="always_delivery_flg" id="crtAlwaysDeliveryFlg" value="1">
                                <label for="crtAlwaysDeliveryFlg">{{ "常時公開" }}</label>
                            </li>
                        </ul>
                        <!-- 登録ボタン -->
                        <button id="curriculumRegistBtn" type="button">{{ "登録" }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        // 登録ボタン押下時ダイアログ
        $('#curriculumRegistBtn').click(function() {
            if(confirm('授業を登録しますか？')) {
                $('#registCurriculumForm').submit();
            }else{
                return false;
            }
        });
    });

</script>
@endsection
