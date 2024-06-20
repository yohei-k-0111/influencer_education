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
                <h1>{{ "授業設定" }}</h1>
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
                    <form id="updateCurriculumForm" action="{{ route('admin.show.curriculum.update', $curriculum->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <ul>
                            <li class="edit-item">
                                <!-- サムネイル画像が登録があれば表示し、未登録の場合はjsでNoImage用画像を表示させる -->
                                <img src="{{ asset($curriculum->thumbnail) }}" alt="{{ $curriculum->thumbnail }}" width="150px" onerror="altThumbnailImage(this);">
                                <label for="editThumbnail">{{ "サムネイル" }}</label>
                                <input type="file" name="thumbnail" id="editThumbnail">
                            </li>
                            <li class="edit-item">
                                <label for="editGradeId">{{ "学年" }}</label>
                                <select name="grade_id" id="editGradeId">
                                    @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ $curriculum->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="edit-item">
                                <label for="editTitle">{{ "授業名" }}</label>
                                <input type="text" value="{{ $curriculum->title }}" name="title" id="editTitle">
                            </li>
                            <li class="edit-item">
                                <label for="editVideoUrl">{{ "動画URL" }}</label>
                                <input type="url" value="{{ $curriculum->video_url }}" name="video_url" id="editVideoUrl">
                            </li>
                            <li class="create-item">
                                    <label for="editDescription">{{ "授業概要" }}</label>
                                    <input type="textarea" value="{{ $curriculum->description }}" name="description" id="editDescription">
                            </li>
                            <li class="edit-item">
                                <!-- 常時公開チェックがONであればvalue=1, OFFであればvalue=0 を送信 -->
                                <input type="hidden" name="always_delivery_flg" value="0" >
                                <input type="checkbox" name="always_delivery_flg" id="editAlwaysDeliveryFlg" value="1" {{ $curriculum->always_delivery_flg ? 'checked' : '' }}>
                                <label for="editAlwaysDeliveryFlg">{{ "常時公開" }}</label>
                            </li>
                        </ul>
                        <!-- 更新ボタン -->
                        <button id="curriculumUpdateBtn" type="button">{{ "更新" }}</button>
                    </form>
                </div>
            </div>
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
