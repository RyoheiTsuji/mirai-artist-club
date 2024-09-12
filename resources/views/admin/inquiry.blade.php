@extends('layouts.app_admin')

@push('scripts')
    <script>
        $(document).ready(function() {
            // liをクリックしたときの処理
            $('.list-group-item').on('click', function() {
                var inquiryId = $(this).data('id'); // liタグに設定したdata-id属性を取得
                console.log("Inquiry ID:", inquiryId);  // IDが正しく取得されているか確認

                // メッセージコンテンツをクリアしてローディング中表示
                $('#messageContent').html('<p>メッセージを読み込み中...</p>');

                // AJAXリクエストでメッセージを取得
                $.ajax({
                    url: '/admin/inquiry/messages/' + inquiryId,
                    method: 'GET',
                    success: function(response) {
                        if(response.messages.length > 0) {
                            var messagesHtml = '<ul class="list-group">';
                            $.each(response.messages, function(index, message) {

                                console.log("Message:", message);

                                messagesHtml += '<li class="list-group-item">';
                                messagesHtml += '<strong>' + message.sender_name + '</strong>: ' + message.body;
                                messagesHtml += '<br><small class="text-muted">' + message.created_at + '</small>';
                                // Bootstrap 5の属性に修正
                                messagesHtml += '<button class="btn btn-sm btn-primary reply-btn" data-bs-toggle="modal" data-bs-target="#replyModal" data-inquiry-id="' + inquiryId + '">返信</button>';
                                messagesHtml += '</li>';
                            });
                            messagesHtml += '</ul>';
                            $('#messageContent').html(messagesHtml);
                        } else {
                            $('#messageContent').html('<p>メッセージがありません。</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ': ' + error);
                        $('#messageContent').html('<p>メッセージの取得に失敗しました。</p>');
                    }
                });
            });

            // モーダルにinquiryIdをセット
            $(document).on('click', '.reply-btn', function() {
                var inquiryId = $(this).data('inquiry-id');
                $('#inquiryIdInput').val(inquiryId); // モーダル内のinputにセット
            });
        });
    </script>

@endpush

@section('content')
    <div class="container">
        <h2>問い合わせ管理</h2>

        <!-- 2カラム構成 -->
        <div class="row">
            <!-- 一般問い合わせリスト -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>一般問い合わせ</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($generalInquiries as $inquiry)

                                <li class="list-group-item d-flex justify-content-between align-items-center p-4" data-id="{{ $inquiry->id }}">
                                    <div>
                                        @if($inquiry->submitted_by_user_id && $inquiry->user)
                                            <strong>{{ $inquiry->user->name }}</strong><br>
                                        @elseif($inquiry->created_by_artist_id && $inquiry->artist)
                                            <strong>{{ $inquiry->artist->name }}</strong><br>
                                        @elseif($inquiry->created_by_admin_id && $inquiry->admin)
                                            <strong>{{ $inquiry->admin->name }}</strong><br>
                                        @else
                                            <strong>不明な送信者</strong><br>
                                        @endif
                                        <span>{{ $inquiry->subject }}</span>
                                        <div class="small text-muted">
                                            受信日: {{ $inquiry->created_at->format('Y-m-d') }}<br>
                                            最終対応日: {{ $inquiry->updated_at->format('Y-m-d') }}
                                        </div>
                                    </div>
                                    <span class="badge {{ $inquiry->status === 0 ? 'bg-danger' : ($inquiry->status === 1 ? 'bg-warning' : 'bg-secondary') }}">
                                        {{ $inquiry->status === 0 ? '未対応' : ($inquiry->status === 1 ? '対応中' : '完了') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 作家問い合わせリスト -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>作家問い合わせ</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">

                            @foreach($artistInquiries as $inquiry)
                                <li class="list-group-item d-flex justify-content-between align-items-center p-4" data-id="{{ $inquiry->id }}">
                                    <div>
                                        @if($inquiry->submitted_by_user_id && $inquiry->user)
                                            <strong>{{ $inquiry->user->name }}</strong><br>
                                        @elseif($inquiry->created_by_artist_id && $inquiry->artist)
                                            <strong>{{ $inquiry->artist->name }}</strong><br>
                                        @elseif($inquiry->created_by_admin_id && $inquiry->admin)
                                            <strong>{{ $inquiry->admin->name }}</strong><br>
                                        @else
                                            <strong>不明な送信者</strong><br>
                                        @endif
                                        <span>{{ $inquiry->subject }}</span>
                                        <div class="small text-muted">
                                            受信日: {{ $inquiry->created_at->format('Y-m-d') }}<br>
                                            最終対応日: {{ $inquiry->updated_at->format('Y-m-d') }}
                                        </div>
                                    </div>
                                    <span class="badge {{ $inquiry->status === 0 ? 'bg-danger' : ($inquiry->status === 1 ? 'bg-warning' : 'bg-secondary') }}">
            {{ $inquiry->status === 0 ? '未対応' : ($inquiry->status === 1 ? '対応中' : '完了') }}
        </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 下段: メッセージのやり取り表示エリア -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>メッセージのやり取り</h4>
                    </div>
                    <div class="card-body" id="messageContent">
                        <!-- メッセージのやり取りを動的に表示 -->
                        <p>選択された問い合わせのメッセージがここに表示されます。</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 返信用のモーダル -->
        <!-- モーダルのHTML -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">返信を送信する</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="replyForm" action="{{ route('inquiry.reply') }}" method="POST">
                            @csrf
                            <input type="hidden" name="inquiry_id" id="inquiryIdInput" value="">
                            <div class="mb-3">
                                <label for="replyMessage" class="form-label">返信内容</label>
                                <textarea class="form-control" id="replyMessage" name="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">送信</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
