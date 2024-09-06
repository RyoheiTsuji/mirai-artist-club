@extends('layouts.app_admin')

@push('scripts')
@endpush

@section('content')
    <div class="container">
        <h2 class="mb-4">メッセージ管理</h2>

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
                            <li class="list-group-item">作家次郎さんにオファーを送りました。</li>
                            <li class="list-group-item">作家美咲さんにメッセージを送りました。</li>
                            <li class="list-group-item">作家光太郎さんから質問が届きました。</li>
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
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                作家太郎さんからの質問
                                <span class="badge bg-danger">未対応</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                作家光太郎さんからの提案
                                <span class="badge bg-warning">対応中</span>
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
                                    <li class="list-group-item">
                                        <strong>作家太郎さん</strong>：さらに質問があります。<br>
                                        <small class="text-muted">2024年8月10日 16:30</small>
                                    </li>
                                </ul>
                            </li>
                            <li class="list-group-item mt-3">
                                <strong>作家花子さん</strong>：報酬についての相談<br>
                                <small class="text-muted">2024年8月9日 10:00</small>
                                <ul class="list-group mt-2">
                                    <li class="list-group-item">
                                        <strong>管理者</strong>：提案を受け取りました。<br>
                                        <small class="text-muted">2024年8月9日 11:00</small>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>作家花子さん</strong>：承諾します。<br>
                                        <small class="text-muted">2024年8月9日 12:00</small>
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
