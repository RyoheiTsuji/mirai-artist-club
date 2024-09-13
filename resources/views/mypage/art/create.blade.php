@extends('layouts.app_mypage')

@push('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const img = document.getElementById('uploaded-image');
            const canvas = document.getElementById('canvas');
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                img.style.display = 'block';

                // Cropper.jsを適用
                const cropper = new Cropper(img, {
                    aspectRatio: 1, // アスペクト比を1:1（正方形）に設定
                    viewMode: 1, // クロップエリアの表示モード
                    scalable: true, // 画像を拡大縮小できる
                    zoomable: true, // ズームイン・アウトが可能
                    movable: true, // 画像を移動できる
                    ready: function () {
                        // プレビューエリア内での画像表示を固定サイズにする
                        const containerData = cropper.getContainerData();
                        const canvasData = cropper.getCanvasData();
                        const cropBoxData = cropper.getCropBoxData();

                        // 必要に応じて、キャンバスの初期サイズや位置を調整
                        cropper.setCropBoxData({
                            left: 0,
                            top: 0,
                            width: containerData.width,
                            height: containerData.height,
                        });
                    }
                });

                // トリミングされた画像を取得
                document.getElementById('form-submit').addEventListener('click', function() {
                    canvas.style.display = 'block';
                    const ctx = canvas.getContext('2d');

                    // Canvasのサイズをトリミング後のサイズに設定
                    canvas.width = cropper.getData().width;
                    canvas.height = cropper.getData().height;

                    // トリミングされた画像をCanvasに描画
                    ctx.drawImage(cropper.getCroppedCanvas(), 0, 0);

                    // トリミングされた画像をBlobとして取得して、サーバーに送信
                    canvas.toBlob(function(blob) {
                        // ここでフォームにblobを追加するなど、サーバー送信用の処理を行います
                    }, 'image/jpeg');
                });
            };

            reader.readAsDataURL(file);
        });


    </script>
@endpush

@section('content')
    <h1>作品を登録</h1>

    <form action="{{ route('mypage.art.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">作品名</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">説明</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="production_year">制作年</label>
            <input type="number" name="year" id="production_year" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="size">作品サイズ</label>
            <input type="text" name="size" id="size" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tags">作風タグを選択</label>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tags[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}">
                    <label class="form-check-label" for="tag{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="image">作品画像</label>
            <input type="file" name="image" id="image" class="form-control-file" required>
        </div>

        <style>
            .img-edit {
                width: 480px;
                height: 320px;
                overflow: hidden;
                margin-top: 10px;
            }
        </style>

        <div class="img-edit" style="width:100%; max-width: 300px; margin-top: 10px;">
            <img id="uploaded-image" style="width: 100%; display: none;" alt="ファイルプレビュー">
            <canvas id="canvas" style="display: none;"></canvas>
        </div>
        <button type="submit" class="btn btn-primary">登録する</button>
    </form>
@endsection
