@extends('layouts.app_admin')

@push('scripts')
    <script>
        $(document).ready(function() {
            // フォームを初期状態で隠す
            $('#messageFormContainer').hide();

            // 新規作成ボタンのクリックイベント
            $('#newMessageButton').on('click', function() {
                $('#messageFormContainer').slideToggle('slow', function() { // アニメーション完了後に実行
                    // ボタンのテキストとアイコンを切り替え
                    if ($('#messageFormContainer').is(':visible')) {
                        $('#newMessageButton').html('<i class="fas fa-times-circle"></i> 閉じる'); // 閉じる状態
                        $('#newMessageButton').removeClass('btn-primary').addClass('btn-secondary'); // ボタンの色変更
                    } else {
                        $('#newMessageButton').html('<i class="fas fa-plus-circle"></i> 新規作成'); // 新規作成状態
                        $('#newMessageButton').removeClass('btn-secondary').addClass('btn-primary'); // ボタンの色戻す
                    }
                });
            });



        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">メッセージ管理</h2>
            <!-- 新規作成ボタン -->
            <button id="newMessageButton" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> 新規作成
            </button>
        </div>

        <!-- スライドアップで表示されるメッセージ入力フォーム -->
        <div id="messageFormContainer" class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4>新規メッセージ作成</h4>
                </div>
                <div class="card-body">
                    <form id="messageForm" action="{{ route('admin.message.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="sender_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="sender_type" value="admin">
                            <label for="recipient" class="form-label">宛先</label>
                            <div id="recipient-list" class="form-check">
                                <!-- 検索された作家を表示するエリア -->
                                @error('recipients')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#artistSearchModal">
                                作家を検索
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">タイトル</label>
                            <input type="text" id="title" name="title" class="form-control" rows="4" required>
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">メッセージ</label>
                            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                            @error('message')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">送信</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- モーダルウィンドウの読み込み -->
        @include('components.artist-search')

        <!-- 以下は既存のコンテンツ -->
        <!-- 上段: 2カラム構成 -->
        <div class="row mb-4">
            <!-- 左カラム: 過去5件のアクション -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>過去5件のアクション</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">作家太郎さんに返信しました。</li>
                            <li class="list-group-item">作家花子さんからメッセージが届いています。</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 右カラム: 未対応のメッセージリスト -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>未対応メッセージリスト</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                作家花子さんからのメッセージ
                                <span class="badge bg-danger">未対応</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 下段: メッセージのやりとりリスト（ツリー表示） -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>直近のメッセージやりとり</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>作家太郎さん</strong>：案件についての質問<br>
                                <small class="text-muted">2024年8月10日 14:30</small>
                                <ul class="list-group mt-2">
                                    <li class="list-group-item">
                                        <strong>管理者</strong>：質問の回答を送信しました。<br>
                                        <small class="text-muted">2024年8月10日 15:00</small>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
