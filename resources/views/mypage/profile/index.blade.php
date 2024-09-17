@extends('layouts.app_mypage')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#nav_profile a').addClass('active');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const uploadForm = document.querySelector('#uploadImageForm');
            const uploadModal = new bootstrap.Modal(document.getElementById('uploadImageModal'));

            uploadForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(uploadForm);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('{{ route('mypage.photo.upload') }}', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': csrfToken},
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
                        alert('画像のアップロードに失敗しました。');}
                    );
            });
        });
    </script>
@endpush
@section('content')
    @php
        $birthday = isset($artist->birthday) ? \Carbon\Carbon::parse($artist->birthday)->format('Y-m-d') : '未登録';
        $zodiacSign = \App\Helpers\Zodiac::getZodiacSign($birthday);
    @endphp
    <div class="container">
        <div class="card mt-4 mb-4">
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
                <h2 class="section-title">my profile</h2>
                <dl class="row artist-detail">
                    <dt class="col-3">name</dt>
                    <dd class="col-9">{{ $artist->name }} <span class="furigana">({{ $artist->furigana ?? 'フリガナの登録がありません'  }})</span></dd>

                    <dt class="col-3">birthday</dt>
                    <dd class="col-9">{{ $birthday ?? '登録がありません'  }} <span class="zodiac">({{ $zodiacSign }})</span></dd>

                    <dt class="col-3">email</dt>
                    <dd class="col-9">{{ $artist->email }}</dd>

                    <dt class="col-3">phone</dt>
                    <dd class="col-9">{{ $artist->phone_number }}</dd>

                    <dt class="col-3">address</dt>
                    <dd class="col-9">{{ $artist->address ?? '登録がありません' }}</dd>

                    <dt class="col-3">P R</dt>
                    <dd class="col-9">{{ $artist->pr_statement ?? '登録がありません' }}</dd>

                    <dt class="col-3">biography</dt>
                    <dd class="col-9">{{ $artist->bio ?? '登録がありません' }}</dd>


                    <dt class="col-3">portfolio</dt>
                    <dd class="col-9">
                        @if (!empty($artist['portfolio_pdf']))
                            <span class="badge bg-success">登録済み</span>
                        @else
                            <span class="badge bg-danger">未登録</span>
                        @endif
                    </dd>
                </dl>
            </div>
            <div class="row">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="button" class="btn btn-primary">ポートフォリオ登録</button>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="button" class="btn btn-primary">パスワード変更</button>
                </div>
            </div>
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
                                <label for="furigana" class="form-label">フリガナ</label>
                                <input type="text" class="form-control" id="furigana" name="furigana" value="{{ $artist->furigana }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">メールアドレス</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $artist->email }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">電話番号</label>
                                <input type="tel" class="form-control" id="phone" name="phone_number" value="{{ $artist->phone_number }}">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">住所</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $artist->address }}">
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">バイオグラフィ</label>
                                <textarea class="form-control" id="bio" name="bio">{{ $artist->bio }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="pr" class="form-label">PR文</label>
                                <textarea class="form-control" id="pr" name="pr_statement">{{ $artist->pr_statement }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">保存</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
