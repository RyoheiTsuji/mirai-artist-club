@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_comment a').addClass('active');

            // コメントのステータス変更 (公開/非公開) のAJAX処理
            $('.form-check-input').on('change', function() {
                let commentId = $(this).data('comment-id');
                let status = $(this).prop('checked') ? 1 : 0; // チェックされていれば公開(1)、そうでなければ非公開(0)

                $.ajax({
                    url: "{{ route('mypage.comment.toggleStatus') }}", // ルートを指定
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment_id: commentId,
                        status: status
                    },
                    success: function(response) {
                        alert('ステータスが更新されました。');
                    },
                    error: function(xhr) {
                        alert('ステータス更新に失敗しました。');
                    }
                });
            });

            // 編集ボタンがクリックされたらフォームに値をセット
            $('.btn-edit').on('click', function() {
                let commentId = $(this).data('comment-id');
                let commentContent = $(this).data('comment-content');

                $('#registerForm').find('input[name="comment_id"]').val(commentId); // コメントIDをセット
                $('#registerForm').find('textarea[name="comment"]').val(commentContent); // コメント内容をセット
                $('#registerForm').find('label[for="comment_content"]').text('コメントを編集'); //タイトルを変更

            });

            // 削除ボタンのAJAX処理
            $('.btn-delete').on('click', function() {
                if (!confirm('本当に削除しますか？')) return;
                let commentId = $(this).data('comment-id');
                $.ajax({
                    url: "{{ route('mypage.comment.delete') }}", // ルートを指定
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment_id: commentId
                    },
                    success: function(response) {
                        alert('コメントが削除されました。');
                        location.reload(); // ページをリロードして反映
                    },
                    error: function(xhr) {
                        alert('コメント削除に失敗しました。');
                    }
                });
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
        <h1 class="page_title">コメント管理</h1>

        <!-- コメント投稿フォーム -->
        <div class="card mb-3">
            <form action="{{ route('mypage.comment.register') }}" method="POST" id="registerForm">
                @csrf
                <div class="form-group mb-3">
                    <label for="comment_content" class="form-label">新規コメント投稿</label>
                    <textarea name="comment" id="comment_content" cols="30" rows="6" class="form-control"></textarea>
                </div>
                <div class="form-group mb-2">
                    <input type="hidden" name="comment_id" value="">
                    <button type="submit" class="btn btn-primary w-75 m-auto d-block">送 信</button>
                </div>
            </form>
        </div>

        <!-- コメント履歴 -->
        <div class="container" id="commentBox">
            <h2 class="section_title">コメント履歴</h2>
            <ul class="list-group commentBox history">
                <!-- コメントリスト -->
                @foreach ($comments as $comment)
                    <li class="list-group-item">
                        <span class="me-2 d-block text-decoration-underline">{{ $comment->created_at->format('Y.m.d') }}</span>
                        <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check form-switch d-flex align-items-center">
                                <label class="form-check-label me-5 pe-2" for="status{{ $comment->id }}">非公開</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="status{{ $comment->id }}" data-comment-id="{{ $comment->id }}" {{ $comment->status ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="status{{ $comment->id }}">公開中</label>
                            </div>
                            <div class="d-flex justify-content-end btnBox">
                                <button class="btn btn-success btn-edit" data-comment-id="{{ $comment->id }}" data-comment-content="{{ $comment->content }}">修 正</button>
                                <button class="btn btn-secondary ms-3 btn-delete" data-comment-id="{{ $comment->id }}">削 除</button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
