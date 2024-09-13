@extends('layouts.app_admin')
@push('description')
    //
@endpush
@push('scripts')
    <script>
        function deleteOffer(offerId) {
            if (confirm('本当に削除しますか？')) {
                // フォームを動的に作成してPOSTリクエストを送信
                var form = document.createElement('form');
                form.setAttribute('method', 'POST');
                form.setAttribute('action', '{{ route('admin.offer.delete') }}');

                var csrfToken = document.createElement('input');
                csrfToken.setAttribute('type', 'hidden');
                csrfToken.setAttribute('name', '_token');
                csrfToken.setAttribute('value', '{{ csrf_token() }}');
                form.appendChild(csrfToken);

                var offerInput = document.createElement('input');
                offerInput.setAttribute('type', 'hidden');
                offerInput.setAttribute('name', 'offer_id');
                offerInput.setAttribute('value', offerId);
                form.appendChild(offerInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush

@section('content')



    <div class="container">
        <h2 class="mb-4 page_title">案件管理</h2>

        <div class="row">
            <!-- 案件案内機能 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h2 class="h5">最近登録された案件</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($offers as $offer)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $offer->title }}</span>
                                    <div>
                                        <a href="{{ route('admin.offer.edit', $offer->id) }}" class="text-muted me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.offer.delete', $offer->id) }}" class="text-muted" onclick="return confirm('本当に削除しますか？')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <!-- 新しい案件を作成ボタン -->
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.offer.create') }}" class="btn btn-primary">新しい案件を作成</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 案件集計機能 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h2 class="h5">案件集計</h2>
                    </div>
                    <div class="card-body">
                        <p>案内に対する作家からのリアクションなどを集計する機能です。</p>
                        <!-- 案件のリスト表示 -->
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>案件タイトル1</strong><br>
                                    <span class="text-muted">ステータス: 進行中</span>
                                </div>
                                <span class="badge bg-primary rounded-pill">5 希望者</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>案件タイトル2</strong><br>
                                    <span class="text-muted">ステータス: 完了</span>
                                </div>
                                <span class="badge bg-primary rounded-pill">10 希望者</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>案件タイトル3</strong><br>
                                    <span class="text-muted">ステータス: 未開始</span>
                                </div>
                                <span class="badge bg-primary rounded-pill">3 希望者</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 案件管理機能 -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5">メッセージのやり取り</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <!-- ここに各案件のツリー構造を表示 -->
                            <li class="list-group-item">
                                <strong>案件名: サンプルプロジェクト 作家名: 山田太郎</strong>
                                <ul class="list-group mt-2">
                                    <li class="list-group-item">
                                        <div>
                                            <strong>山田太郎</strong> (2024-08-30 10:15 AM):<br>
                                            初めまして、案件の詳細についてお伺いしたいです。
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div>
                                            <strong>管理者</strong> (2024-08-30 10:45 AM):<br>
                                            山田様、案件の詳細は以下の通りです。
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div>
                                            <strong>山田太郎</strong> (2024-08-30 11:00 AM):<br>
                                            ありがとうございます。内容を確認します。
                                        </div>
                                    </li>
                                    <!-- さらにメッセージが続く -->
                                </ul>
                            </li>
                            <!-- さらに案件が続く -->
                            <li class="list-group-item">
                                <strong>案件名: 別のプロジェクト 作家名: 鈴木花子</strong>
                                <ul class="list-group mt-2">
                                    <li class="list-group-item">
                                        <div>
                                            <strong>鈴木花子</strong> (2024-08-29 09:00 AM):<br>
                                            案件について相談したいことがあります。
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div>
                                            <strong>管理者</strong> (2024-08-29 09:30 AM):<br>
                                            鈴木様、ご質問をどうぞ。
                                        </div>
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

