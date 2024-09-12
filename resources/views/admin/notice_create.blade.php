@extends('layouts.app_admin')

@section('content')
    <div id="content_wrapper">
        <h2 class="page-title" id="page_title">サイトへのお知らせ - 作成</h2>

        <!-- 成功メッセージ -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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

        <!-- フォームの表示 -->
        <form action="{{ route('admin.notice.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- お知らせタイトル -->
            <div class="mb-3">
                <label for="title" class="form-label">お知らせタイトル</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <!-- お知らせ内容 -->
            <div class="mb-3">
                <label for="content" class="form-label">お知らせ内容</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <!-- イベント開始日 -->
            <div class="mb-3">
                <label for="event_start_date" class="form-label">イベント開始日</label>
                <input type="date" class="form-control" id="event_start_date" name="event_start_date" value="{{ old('event_start_date') }}">
            </div>

            <!-- イベント終了日 -->
            <div class="mb-3">
                <label for="event_end_date" class="form-label">イベント終了日</label>
                <input type="date" class="form-control" id="event_end_date" name="event_end_date" value="{{ old('event_end_date') }}">
            </div>

            <!-- 掲載開始日 -->
            <div class="mb-3">
                <label for="publish_start_date" class="form-label">掲載開始日</label>
                <input type="date" class="form-control" id="publish_start_date" name="publish_start_date" value="{{ old('publish_start_date') }}">
            </div>

            <!-- 掲載終了日 -->
            <div class="mb-3">
                <label for="publish_end_date" class="form-label">掲載終了日</label>
                <input type="date" class="form-control" id="publish_end_date" name="publish_end_date" value="{{ old('publish_end_date') }}">
            </div>

            <!-- カレンダーフラグ -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="calendar_flag" name="calendar_flag" value="1" {{ old('calendar_flag') ? 'checked' : '' }}>
                <label class="form-check-label" for="calendar_flag">カレンダーに表示</label>
            </div>

            <!-- 画像 -->
            <div class="mb-3">
                <label for="photo" class="form-label">画像</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <!-- 送信ボタン -->
            <button type="submit" class="btn btn-primary">お知らせを登録</button>
        </form>
    </div>
@endsection
