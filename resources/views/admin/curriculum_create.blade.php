@extends('admin.layouts.app')

@section('content')
<div class="main-outline">
    <div class="main-content">
        <div class="main-content--header">
            <!-- 管理トップ画面へ戻るボタン -->
            <div class="button--return">
                <a href="{{ route('admin.show.curriculum.list') }}">{{ "←戻る" }}</a>
            </div>
            <!-- 画面タイトル -->
            <h1 class="main-content--header__display-title">{{ "新規授業登録" }}</h1>
            <div class="main-content--header__alert">
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
            </div>
        </div>
        <div class="main-content--body">
            <!-- 入力フォーム -->
            <form id="registerCurriculumForm" class="form register-form" action="{{ route('admin.show.curriculum.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <ul class="form--item">
                    <li class="form--item__list">
                        <label for="crtThumbnail">{{ "サムネイル" }}</label>
                        <input type="file" name="thumbnail" id="crtThumbnail">
                    </li>
                    <li class="form--item__list grade-row">
                        <!-- 必須項目（学年） -->
                        <label for="crtGradeId">{{ "学年" }}</label>
                        <select name="grade_id" id="crtGradeId">
                            @foreach($grades as $grade)
                            <!-- 前画面（一覧画面）にて選択した学年を初期表示させる -->
                            <option value="{{ $grade->id }}" {{ $select_grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="form--item__list title-row">
                        <!-- 必須項目（授業名） -->
                        <label for="crtTitle">{{ "授業名" }}<span class="title-row--required">*</span></label>
                        <input type="text" name="title" id="crtTitle">
                    </li>
                    <li class="form--item__list url-row">
                        <label for="crtVideoUrl">{{ "動画URL" }}</label>
                        <input type="url" name="video_url" id="crtVideoUrl">
                    </li>
                    <li class="form--item__list description-row">
                        <label for="crtDescription">{{ "授業概要" }}</label>
                        <textarea name="description" id="crtDescription" wrap="hard" maxlength="2000"></textarea>
                    </li>
                    <li class="form--item__list flg-row">
                        <div class="flg-row--check-box">
                            <!-- 常時公開チェックがONであればvalue=1, OFFであればvalue=0 を送信 -->
                            <input type="hidden" name="always_delivery_flg" value="0" >
                            <input type="checkbox" name="always_delivery_flg" id="crtAlwaysDeliveryFlg" value="1">
                        </div>
                        <div class="flg-row--label">
                            <label for="crtAlwaysDeliveryFlg">{{ "常時公開" }}</label>
                        </div>
                    </li>
                    <li class="form--item__list title-row--required">{{"* は必須項目です"}}</li>
                </ul>
                <div class="form--item form--button">
                    <!-- 登録ボタン -->
                    <button class="form--button__tag form--button__curriculum"  id="curriculumRegisterBtn" type="button">{{ "登録" }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        // 登録ボタン押下時ダイアログ
        $('#curriculumRegisterBtn').click(function() {
            if(confirm('授業を登録しますか？')) {
                $('#registerCurriculumForm').submit();
            }else{
                return false;
            }
        });
    });

</script>
@endsection
