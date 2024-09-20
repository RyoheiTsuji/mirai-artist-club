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

            const sizeW2D = document.getElementById('size_w_2d');
            const sizeH2D = document.getElementById('size_h_2d');
            const sizeW3D = document.getElementById('size_w_3d');
            const sizeH3D = document.getElementById('size_h_3d');
            const sizeD3D = document.getElementById('size_d');
            const sizeO = document.getElementById('size_o');

            // 初期表示設定
            twoDimension.style.display = 'block';
            threeDimension.style.display = 'none';
            otherDimension.style.display = 'none';
            sizeW3D.disabled = true;
            sizeH3D.disabled = true;
            sizeD3D.disabled = true;
            sizeO.disabled = true;

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.id === 'btnradio1') {
                        // 2Dの選択時
                        twoDimension.style.display = 'block';
                        threeDimension.style.display = 'none';
                        otherDimension.style.display = 'none';

                        // 2Dのフィールドを有効化、他を無効化
                        sizeW2D.disabled = false;
                        sizeH2D.disabled = false;
                        sizeW3D.disabled = true;
                        sizeH3D.disabled = true;
                        sizeD3D.disabled = true;
                        sizeO.disabled = true;
                    } else if (this.id === 'btnradio2') {
                        // 3Dの選択時
                        twoDimension.style.display = 'none';
                        threeDimension.style.display = 'block';
                        otherDimension.style.display = 'none';
                        // 3Dのフィールドを有効化、他を無効化
                        sizeW2D.disabled = true;
                        sizeH2D.disabled = true;
                        sizeW3D.disabled = false;
                        sizeH3D.disabled = false;
                        sizeD3D.disabled = false;
                        sizeO.disabled = true;
                    } else if (this.id === 'btnradio3') {
                        // その他の選択時
                        twoDimension.style.display = 'none';
                        threeDimension.style.display = 'none';
                        otherDimension.style.display = 'block';
                        // その他のフィールドを有効化、他を無効化
                        sizeW2D.disabled = true;
                        sizeH2D.disabled = true;
                        sizeW3D.disabled = true;
                        sizeH3D.disabled = true;
                        sizeD3D.disabled = true;
                        sizeO.disabled = false;
                    }
                });
            });

            // 新しい"販売状況"のチェックボックス処理
            const saleTypeCheckboxes = document.querySelectorAll('input[name="sale_type[]"]');
            const reasonGroup = document.getElementById('reason-group');

            saleTypeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // "その他" (5) がチェックされたときに理由入力フィールドを表示
                    if (this.value == 5 && this.checked) {
                        reasonGroup.style.display = 'block';
                    } else if (this.value == 5 && !this.checked) {
                        reasonGroup.style.display = 'none';
                    }
                });
            });
        });
        // フォーム送信前に、無効化されているフィールドは送信されない
        document.querySelector('form').addEventListener('submit', function(event) {
            // 送信前に無効化されたフィールドが含まれないようにする
            sizeW2D.disabled = !document.getElementById('btnradio1').checked;
            sizeH2D.disabled = !document.getElementById('btnradio1').checked;
            sizeW3D.disabled = !document.getElementById('btnradio2').checked;
            sizeH3D.disabled = !document.getElementById('btnradio2').checked;
            sizeD3D.disabled = !document.getElementById('btnradio2').checked;
            sizeO.disabled = !document.getElementById('btnradio3').checked;
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
                    <input type="radio" class="btn-check" name="dimension_type" id="btnradio1" value="2D" autocomplete="off" checked>
                    <label class="btn btn-outline-secondary" for="btnradio1">2D</label>

                    <input type="radio" class="btn-check" name="dimension_type" id="btnradio2" value="3D" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio2">3D</label>

                    <input type="radio" class="btn-check" name="dimension_type" id="btnradio3" value="other" autocomplete="off">
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
        <!-- 販売状況選択 (SALE_TYPES) -->
        <div class="form-group">
            <label for="sale_type" class="form-label">販売可否</label>
            <div id="sale_type_options">
                @foreach(config('admin_setting.SALE_TYPES') as $key => $value)
                    <div class="form-check">
                        <input type="checkbox" name="sale_type[]" id="sale_type_{{ $key }}" value="{{ $key }}" class="form-check-input">
                        <label class="form-check-label" for="sale_type_{{ $key }}">{{ $value }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- 理由 (その他が選択された場合のみ表示される) -->
        <div class="form-group" id="reason-group" style="display: none;">
            <label for="reason" class="form-label">理由</label>
            <input type="text" name="reason" id="reason" class="form-control" placeholder="理由を記入してください">
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
