@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_artwork a').addClass('active');
        });

        document.getElementById('uploadButton').addEventListener('click', function() {
            document.getElementById('image').click(); // アイコンボタンをクリックしたときにファイル選択ダイアログを開く
        });

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imgPreview = document.getElementById('imagePreview');
            const previewAlert = document.getElementById('preview-alert');
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
                        if (aspectRatio > (16 / 9)) {
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

        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="dimension_type"]');
            const twoDimension = document.getElementById('two-dimension');
            const threeDimension = document.getElementById('three-dimension');
            const otherDimension = document.getElementById('other-dimension');

            // 初期表示設定
            twoDimension.style.display = 'block';
            threeDimension.style.display = 'none';
            otherDimension.style.display = 'none';

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.id === 'btnradio1') {
                        // 2Dの選択時
                        twoDimension.style.display = 'block';
                        threeDimension.style.display = 'none';
                        otherDimension.style.display = 'none';
                    } else if (this.id === 'btnradio2') {
                        // 3Dの選択時
                        twoDimension.style.display = 'none';
                        threeDimension.style.display = 'block';
                        otherDimension.style.display = 'none';
                    } else if (this.id === 'btnradio3') {
                        // その他の選択時
                        twoDimension.style.display = 'none';
                        threeDimension.style.display = 'none';
                        otherDimension.style.display = 'block';
                    }
                });
            });
        });

    </script>
@endpush

@section('content')
    <div class="container my-3">
    <h1 class="page_title">登録作品</h1>
    <form action="{{ route('mypage.art.store') }}" id="postArtworks" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">作品画像</label>
            <div class="preview-container">
                <p class="preview-alert" id="preview-alert">作品画像を選択してください</p>
                <img id="imagePreview" class="imgPreview" style="" alt="Image Preview">
                <button type="button" id="uploadButton" class="btn btn-secondary mt-2 upldBtn">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </button>
            </div>
            <input type="file" name="image" id="image" class="form-control-file img-post" accept="image/*" required style="display: none;">

        </div>

        <div class="form-group">
            <label for="title" class="form-label">作品名</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="material" class="form-label">素材</label>
            <input type="text" name="material" id="material" class="form-control" required>
        </div>

        <div class="form-group" id="artwork_size">
            <label for="size" class="form-label">作品サイズ</label>
            <div class="row ps-2 mb-2">
                <div class="btn-group mb-3" role="group" aria-label="Basic radio toggle button group" style="font-size:0.8rem">
                    <input type="radio" class="btn-check" name="dimension_type" id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-secondary" for="btnradio1">2D</label>

                    <input type="radio" class="btn-check" name="dimension_type" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio2">3D</label>

                    <input type="radio" class="btn-check" name="dimension_type" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio3">その他</label>
                </div>
                <div id="two-dimension" class="select-dimension active">
                    <div class="row">
                        <div class="col-6">
                            <label for="size_h_2d">縦：</label><input type="number" name="size_h" id="size_h_2d" class="form-control" required>cm
                        </div>
                        <div class="col-6">
                            <label for="size_w_2d">横：</label><input type="number" name="size_w" id="size_w_2d" class="form-control" required>cm
                        </div>
                    </div>
                </div>
                <div id="three-dimension" class="select-dimension row" style="display: none;">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label for="size_h_3d">高さ：</label><input type="number" name="size_h" id="size_h_3d" class="form-control" required>cm
                        </div>
                        <div class="col-6 mb-2">
                            <label for="size_w_3d">幅：</label><input type="number" name="size_w" id="size_w_3d" class="form-control" required>cm
                        </div>
                        <div class="col-8">
                            <label for="size_d">奥行：</label><input type="number" name="size_d" id="size_d" class="form-control" required>cm
                        </div>
                    </div>
                </div>
                <div id="other-dimension" class="select-dimension " style="display: none;">
                    <div class="col-8 mx-auto">
                        <label for="size_o">その他：</label><input type="text" name="size_o" id="size_o" class="form-control otherD">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="tags" class="form-label">作風タグを選択</label>
            <div class="row ps-2">
            @foreach($tags as $tag)
                <div class="form-check col-4">
                    <input class="form-check-input" type="checkbox" name="tags[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}">
                    <label class="form-check-label" for="tag{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                </div>
            @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">説明</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group mb-3 text-center">
        <button type="submit" class="btn btn-primary" value="complete">登録を完了する</button>
        <button type="submit" class="btn btn-primary" value="sub-image">登録してサブ画像登録へ</button>
        </div>
    </form>
    </div>
@endsection
