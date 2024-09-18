@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_artwork a').addClass('active');
        });
        document.addEventListener('DOMContentLoaded', function() {
            // サブ画像1のボタンとファイル選択
            document.getElementById('uploadButton1').addEventListener('click', function() {
                document.getElementById('image1').click(); // ファイル選択ダイアログを開く
            });

            document.getElementById('image1').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const imgPreview = document.getElementById('imagePreview1');
                const previewAlert = document.getElementById('preview-alert-1');
                const reader = new FileReader();

                if (file) {
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        imgPreview.style.display = 'block'; // 画像を表示
                        previewAlert.style.display = 'none'; // アラートメッセージを非表示にする

                        // 画像の縦横比に基づいてサイズを調整
                        const img = new Image();
                        img.src = e.target.result;

                        img.onload = function() {
                            const aspectRatio = img.width / img.height;
                            if (aspectRatio > (4 / 3)) {
                                imgPreview.style.width = '100%'; // 横長の場合
                                imgPreview.style.height = 'auto';
                            } else {
                                imgPreview.style.width = 'auto'; // 縦長の場合
                                imgPreview.style.height = '100%';
                            }
                        };
                    };

                    reader.readAsDataURL(file);
                } else {
                    imgPreview.style.display = 'none'; // 画像を非表示
                    previewAlert.style.display = 'block'; // アラートメッセージを表示
                }
            });

            // サブ画像2のボタンとファイル選択
            document.getElementById('uploadButton2').addEventListener('click', function() {
                document.getElementById('image2').click(); // ファイル選択ダイアログを開く
            });

            document.getElementById('image2').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const imgPreview = document.getElementById('imagePreview2');
                const previewAlert = document.getElementById('preview-alert-2');
                const reader = new FileReader();

                if (file) {
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        imgPreview.style.display = 'block'; // 画像を表示
                        previewAlert.style.display = 'none'; // アラートメッセージを非表示にする

                        // 画像の縦横比に基づいてサイズを調整
                        const img = new Image();
                        img.src = e.target.result;

                        img.onload = function() {
                            const aspectRatio = img.width / img.height;
                            if (aspectRatio > (4 / 3)) {
                                imgPreview.style.width = '100%'; // 横長の場合
                                imgPreview.style.height = 'auto';
                            } else {
                                imgPreview.style.width = 'auto'; // 縦長の場合
                                imgPreview.style.height = '100%';
                            }
                        };
                    };

                    reader.readAsDataURL(file);
                } else {
                    imgPreview.style.display = 'none'; // 画像を非表示
                    previewAlert.style.display = 'block'; // アラートメッセージを表示
                }
            });
        });

    </script>
@endpush

@section('content')

    <div class="container mt-3 mb-3">
        <h1 class="page_title">サブ画像登録</h1>
        <div class="img_container mb-3">
            <h2 class="section-title">紐づくメイン画像</h2>
            <img id="main_image"
                 src="{{ $artwork->image_path ? url(Storage::url($artwork->image_path)) : url('default_image.jpg') }}"
                 alt="作品名：{{ $artwork->title }}">
        </div>
        <div class="sub-image">
            <form action="{{ route('mypage.art.sub_image.register', $artwork->id) }}" id="sub-image-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group card mb-3" id="sub_1">
                    <div class="card-header">サブ画像 1</div>
                    <div class="preview-container mb-2">
                        <p class="preview-alert" id="preview-alert-1">サブ画像を選択してください</p>
                        <img id="imagePreview1" class="imgPreview" alt="Image Preview" style="display: none;">
                        <button type="button" id="uploadButton1" class="btn btn-secondary mt-2 upldBtn">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </button>
                    </div>
                    <input type="file" name="image[]" id="image1" class="form-control-file img-post" accept="image/*" required style="display: none;">
                    <label for="art_title_1" class="form-label">タイトル</label>
                    <input type="text" name="title[]" id="art_title_1" class="form-control">
                    <label for="description_1" class="form-label">説明</label>
                    <textarea name="description[]" id="description_1" class="form-control"></textarea>
                </div>

                <div class="form-group card mb-3" id="sub_2">
                    <div class="card-header">サブ画像 2</div>
                    <div class="preview-container mb-2">
                        <p class="preview-alert" id="preview-alert-2">サブ画像を選択してください</p>
                        <img id="imagePreview2" class="imgPreview" alt="Image Preview" style="display: none;">
                        <button type="button" id="uploadButton2" class="btn btn-secondary mt-2 upldBtn">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </button>
                    </div>
                    <input type="file" name="image[]" id="image2" class="form-control-file img-post" accept="image/*" required style="display: none;">
                    <label for="art_title_2" class="form-label">タイトル</label>
                    <input type="text" name="title[]" id="art_title_2" class="form-control">
                    <label for="description_2" class="form-label">説明</label>
                    <textarea name="description[]" id="description_2" class="form-control"></textarea>
                </div>

                <div class="form-group card">
                    <input type="hidden" name="parent_id" value="{{ $artwork->id }}">
                    <button type="submit" class="btn btn-primary">登録を完了する</button>
                </div>
            </form>

        </div>
    </div>
@endsection
