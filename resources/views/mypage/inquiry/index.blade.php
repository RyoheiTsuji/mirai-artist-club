@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_inquiry a').addClass('active');

            // ログイン中のアーティストIDをBladeから渡す
            const artistId = "{{ Auth::id() }}"; // Auth::id() を使ってログイン中のユーザーIDを取得

            // CSRFトークンをAjaxリクエストに自動で含める
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // 返信するボタンがクリックされたときにモーダルを表示
            $('button.btn-secondary').on('click', function(e){
                e.preventDefault();

                // 親の list-group-item から親IDと件名、inq_typeを取得
                const inquiryId = $(this).closest('.list-group-item.collapse').prev('.list-group-item').data('inquiry-id');
                const subject = $(this).closest('.list-group-item.collapse').prev('.list-group-item').data('subject');
                const inqType = $(this).closest('.list-group-item.collapse').prev('.list-group-item').data('inq-type');

                // デバッグ用に値をコンソールに表示
                console.log("Inquiry ID (親ID):", inquiryId);
                console.log("Subject (親メッセージの件名):", subject);
                console.log("Inquiry Type (親のinq_type):", inqType);
                console.log("Artist ID (ログイン中のアーティスト):", artistId);

                // モーダルのフォームに取得した値をセット
                $('#modalInquiryId').val(inquiryId); // inquiryId をモーダルにセット
                $('#modalArtistId').val(artistId); // artistId をセット
                $('#modalCreatedByArtistId').val(artistId);
                $('#modalInqType').val(inqType); // 親のinquiryタイプをセット
                $('#modalUserType').val(1); // ユーザータイプをセット
                $('#modalSubject').val(subject); // 親のメッセージの件名をセット

                // モーダルを表示
                const replyModal = new bootstrap.Modal(document.getElementById('replyModal'), {
                    keyboard: false
                });
                replyModal.show(); // モーダルを表示
            });

            // フォームのaction属性を確認
            console.log('送信先URL:', $(this).attr('action'));

            $.ajax({
                url: $(this).attr('action'), // フォームのアクションURLを取得
                method: 'POST',
                data: $(this).serialize(), // フォームデータをシリアライズ
                success: function(response) {
                    console.log('サーバーからのレスポンス:', response); // サーバーの応答をログに出力
                    alert('返信が送信されました。');
                    $('#replyModal').modal('hide'); // モーダルを閉じる
                },
                error: function(xhr, status, error) {
                    console.error('エラーが発生しました:', xhr.responseText); // エラー詳細をログに出力
                    alert('送信中にエラーが発生しました。');
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            // すべてのリストアイテムを取得
            const listItems = document.querySelectorAll('.list-group-item');
            // それぞれのリストアイテムにクリックイベントを設定
            listItems.forEach(function(item) {
                const targetId = item.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);
                // targetElementがnullでない場合にのみイベントを設定
                if (targetElement) {
                    const icon = item.querySelector('.accordion-toggle-icon');
                    // 初期状態: aria-expanded="false" の場合はアイコンをリセット
                    targetElement.addEventListener('shown.bs.collapse', function () {
                        icon.classList.add('rotate-down');
                    });
                    targetElement.addEventListener('hidden.bs.collapse', function () {
                        icon.classList.remove('rotate-down');
                    });
                }
            });
        });
    </script>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mt-3">
        <h1 class="page_title">問い合わせ管理</h1>
        <div class="card mb-3">
            <form action="{{ route('mypage.inquiry.register') }}" method="POST" id="registerForm">
                @csrf
                <div class="form-group mb-2">
                    <label class="form-label">件 名：</label>
                    <input type="text" id="subject" class="form-control" name="subject">
                </div>
                <div class="form-group mb-3">
                    <label for="inquiry_content" class="form-label">問い合わせ内容</label>
                    <textarea name="content" id="inquiry_content" cols="30" rows="6" class="form-control"></textarea>
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary w-75 m-auto d-block">送 信</button>
                </div>
            </form>
        </div>
        <div class="container" id="inbox">
            <h2 class="section_title">受 信 箱</h2>
            <ul class="list-group inbox">
                <!-- ここで動的に問い合わせと返信を表示 -->
                @foreach ($inquiries as $inquiry)
                    <!-- 親の問い合わせのタイトル -->
                    <li class="list-group-item d-flex justify-content-between ps-2"
                        data-bs-toggle="collapse"
                        data-bs-target="#reply{{ $inquiry->id }}"
                        aria-expanded="false"
                        data-inquiry-id="{{ $inquiry->id }}"
                        data-subject="{{ $inquiry->subject }}"
                        data-inq-type="{{ $inquiry->inq_type }}">

                        <span class="accordion-toggle-icon me-1">▶</span> {{ $inquiry->subject }}
                        <span class="ms-auto">{{ $inquiry->created_at->format('Y.m.d') }}</span>
                    </li>
                    <!-- 親の問い合わせに対する返信 (アコーディオン) -->
                    <li class="list-group-item collapse" id="reply{{ $inquiry->id }}">
                        <p>{{ $inquiry->message }}</p>
                        <ul class="list-group list-group-flush mb-2">
                            @foreach ($inquiry->childInquiries as $child)
                                <li class="list-group-item">
                                    <span>{{ $child->subject }} ({{ $child->created_at->format('Y.m.d') }})</span>
                                    <p>{{ $child->message }}</p>
                                </li>
                            @endforeach
                        </ul>
                        <button class="btn btn-secondary ms-auto d-block">返信する</button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">返信フォーム</h5>
                        <button type="button" class="btn-close" style="filter: none"data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="replyForm" action="{{ route('mypage.inquiry.reply') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- CSRFトークン -->
                            <input type="hidden" name="inquiry_id" id="modalInquiryId">
                            <input type="hidden" name="artist_id" id="modalArtistId">
                            <input type="hidden" name="created_by_artist_id" id="modalCreatedByArtistId">
                            <input type="hidden" name="inq_type" id="modalInqType">
                            <input type="hidden" name="user_type" id="modalUserType">
                            <input type="hidden" name="subject" id="modalSubject">
                            <textarea name="message" id="modalMessage" cols="30" rows="6" class="form-control"></textarea>
                            <button type="submit" class="btn btn-primary mt-2 ms-auto d-block">送信</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
