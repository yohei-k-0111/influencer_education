@extends('admin.layouts.app')
@section('title', 'お知らせ一覧')
@section('content')
<section class="wrapper">
    <div>
        <a href="{{ route('admin.show.top') }}" class="arrow">戻る</a>
    </div>
    <div>
        <!-- フラッシュメッセージ -->
        @if (session('article_message'))
        <meta name="success-message" content="{{ session('article_message') }}">    
        @endif
    </div>
    <div class="article-list">
        <h1>お知らせ一覧</h1>
        <form action="{{ route('admin.article.rooting') }}" method="POST">
            @csrf
            <button type="submit" id="createNew" class="btn btn-success btn-sm create-btn">新規作成</button>
        </form>
    
        <div class="article-table">
            <table>
                <thead>
                    <tr>
                        <th>投稿日時</th>
                        <th>タイトル</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article->formatted_date }}</td>
                        <td>{{ $article->title }}</td>
                        <td>
                            <form action="{{ route('admin.article.rooting') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <button type="submit" value="article_edit" class="btn btn-success btn-sm edit-btn">変更する</button>                    
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete-btn btn-sm" data-article_id="{{ $article->id }}" data-url="{{ route('admin.article.destroy') }}">削除</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- ページネーションリンク -->
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection