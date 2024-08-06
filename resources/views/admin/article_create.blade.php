@extends('admin.layouts.app')
@section('title', 'お知らせ新規作成')
@section('content')
<section>
    <div>
        <a href="#">戻る</a>
    </div>
</section>
<section>
    <h1>お知らせ新規</h1>
</section>
<section>
   <label>投稿日時<input type="text"></label>
   <label>タイトル<input type="text"></label>
   <label>本文<textarea></textarea></label>
</section>
@endsection