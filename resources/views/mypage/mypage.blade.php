@extends('layouts.app_mypage')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadForm = document.querySelector('#uploadImageForm');
            const uploadModal = new bootstrap.Modal(document.getElementById('uploadImageModal'));

            uploadForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(uploadForm);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('{{ route('mypage.photo.upload') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                    .then(response => {
                        console.log('AJAXリクエストが送信されました。');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // アップロードされた画像のURLを使ってページを更新するなどの処理
                            document.getElementById('artistPhoto').src = data.photo_url;
                            uploadModal.hide(); // モーダルを閉じる
                            alert('画像がアップロードされました。');
                        } else {
                            alert('画像のアップロードに失敗しました。');
                        }
                    })
                    .catch(error => {
                        console.error('エラー:', error);
                        alert('画像のアップロードに失敗しました。');
                    });
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <h1 class="page_title">マイページ</h1>
        <div class="card">
            <div class="myPhoto">
                <img id="artistPhoto"
                     src="{{ $artist->photo_url ? url(Storage::url($artist->photo_url)) : url('default_image.jpg') }}"
                     alt="アーティストの写真">
                <!-- アイコンを表示 -->
                <ul class="controlBox">
                    <li>
                        <i class="fa-solid fa-cloud-arrow-up" data-bs-toggle="modal" data-bs-target="#uploadImageModal"
                           style="cursor: pointer;"></i>
                    </li>
                    <li>
                        <i class="fa-solid fa-pen-to-square" data-bs-toggle="modal" data-bs-target="#editInfoModal"
                           style="cursor: pointer;"></i>
                    </li>
                </ul>
            </div>
            <div id="artist_detail">
                <h2 class="section-title">プロフィール</h2>
                <p>名前: {{ $artist->name }}</p>
                <p>メールアドレス: {{ $artist->email }}</p>
                <p>住所: {{ $artist->address ?? '登録がありません' }}</p>
                <p>自己紹介: {{ $artist->bio ?? '登録がありません' }}</p>
                <p>PR文: {{ $artist->pr_statement ?? '登録がありません' }}</p>
            </div>
            <p>ポートフォリオURL：<a href="{{ asset('storage/' . $artist['portfolio_pdf']) }} " class="btn btn-secondary">ダウンロード</a></p>
        </div>
        <h2>作品一覧</h2>
        @if($artist->artworks->isEmpty())
            <p>作品がありません。</p>
        @else
            <ul class="list-unstyled d-flex flex-row flex-wrap">
                @foreach($artist->artworks as $artwork)
                    <li class="me-3">
                        <strong>{{ $artwork->title }}</strong> ({{ $artwork->year }})<br>
                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}"
                             style="max-width: 100px;">
                        <p>{{ $artwork->description }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- 画像アップロード用モーダル -->
    <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadImageModalLabel">画像をアップロード</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadImageForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">画像を選択</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">アップロード</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 情報編集用モーダル -->
    <div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInfoModalLabel">情報を編集</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="profileForm">
                        @csrf
                        <!-- 必要な入力フィールドを追加 -->
                        <div class="mb-3">
                            <label for="name" class="form-label">名前</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $artist->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">自己紹介</label>
                            <textarea class="form-control" id="bio" name="bio">{{ $artist->bio }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

