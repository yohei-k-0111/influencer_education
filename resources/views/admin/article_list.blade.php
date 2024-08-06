@extends('admin.layouts.app')
@section('title', 'お知らせ一覧')
@section('content')
<section>
    <div>
        <a href="#">戻る</a>
    </div>
</section>
<section>
    <h1>お知らせ一覧</h1>
    <button type="button" id="createNew">新規作成</button>
</section>
<section>
    <table>
        <thead>
            <tr>投稿日時</tr>
            <tr>タイトル</tr>
        </thead>
        <!-- for文で回す -->
        <tbody>
            <td>2023年7月21日</td>
            <td>授業内容更新についてのお知らせ</td>
            <td><button type="submit">変更する</button><button type="submit">削除</button></td>
        
        </tbody>
    </table>
</section>
@endsection