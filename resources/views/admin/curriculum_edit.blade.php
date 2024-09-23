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
            <h1 class="main-content--header__display-title">{{ "授業設定" }}</h1>
        </div>
        <div class="main-content--body">
            <!-- 入力フォーム -->
            <form id="updateCurriculumForm" class="form edit-form" action="{{ route('admin.show.curriculum.update', $curriculum->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form--item img-row">
                    <!-- サムネイル画像が登録があれば表示し、未登録の場合はjsでNoImage用画像を表示させる -->
                    <div id="imgEditThumbnail">
                        <img class="img--edit" src="{{ asset($curriculum->thumbnail) }}" alt="{{ $curriculum->thumbnail }}" onerror="altThumbnailImage(this);">
                    </div>
                    <div id="fileEditThumbnail">
                        <label for="editThumbnail">{{ "サムネイル" }}</label>
                        <input type="file" name="thumbnail" id="editThumbnail">
                    </div>
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
                    </div>
                </div>
                <ul class="form--item">
                    <li class="form--item__list grade-row">
                        <label for="editGradeId">{{ "学年" }}</label>
                        <select name="grade_id" id="editGradeId">
                            @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ $curriculum->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="form--item__list title-row">
                        <label for="editTitle">{{ "授業名" }}</label>
                        <input type="text" value="{{ $curriculum->title }}" name="title" id="editTitle">
                    </li>
                    <li class="form--item__list url-row">
                        <label for="editVideoUrl">{{ "動画URL" }}</label>
                        <input type="url" value="{{ $curriculum->video_url }}" name="video_url" id="editVideoUrl">
                    </li>
                    <li class="form--item__list description-row">
                        <label for="editDescription">{{ "授業概要" }}</label>
                        <textarea name="description" id="editDescription"  wrap="hard" maxlength="2000">{{ $curriculum->description }}</textarea>
                    </li>
                    <li class="form--item__list flg-row">
                        <div class="flg-row--check-box">
                            <!-- 常時公開チェックがONであればvalue=1, OFFであればvalue=0 を送信 -->
                            <input type="hidden" name="always_delivery_flg" value="0" >
                            <input type="checkbox" name="always_delivery_flg" id="editAlwaysDeliveryFlg" value="1" {{ $curriculum->always_delivery_flg ? 'checked' : '' }}>
                        </div>
                        <div class="flg-row--label">
                            <label for="editAlwaysDeliveryFlg">{{ "常時公開" }}</label>
                        </div>
                    </li>
                </ul>
                <div class="form--item form--button">
                    <!-- 更新ボタン -->
                    <button class="form--button__tag form--button__curriculum" id="curriculumUpdateBtn" type="button">{{ "更新" }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
        // サムネイル画像が存在しない場合、NoImage用画像を表示させる。※可能であればapp.blade.phpに書く。
        function altThumbnailImage(img) {
            img.onerror = null; // 無限ループを防ぐ（imageタグを再読み込みするため）
            img.src = "{{ asset('storage/images/thumbnail/noimage/noimage.jpg') }}"; // NoImage用サムネイルファイルを指定
        }
    $(function() {
        // 更新ボタン押下時ダイアログ
        $('#curriculumUpdateBtn').click(function() {
            if(confirm('授業内容を更新しますか？')) {
                $('#updateCurriculumForm').submit();
            }else{
                return false;
            }
        });
    });
</script>

@endsection
