@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_offer a').addClass('active');
        });

        $(document).ready(function () {
            // スライドアップの初期設定
            $('#question_slider').css({
                bottom: '-300px', // 初期位置は画面外に隠す
            });

            // 質問ボタンがクリックされた時にスライドアップ
            $('#questions').click(function (e) {
                e.preventDefault();
                var slider = $('#question_slider');

                if (slider.css('bottom') === '-300px') {
                    // スライドアップ
                    slider.animate({ bottom: '0px' }, 500);
                } else {
                    // スライドダウン
                    slider.animate({ bottom: '-300px' }, 500);
                }
            });

            // タブをドラッグして高さを調整
            $('#slider_tab').on('mousedown touchstart', function(e) {
                e.preventDefault(); // タブのドラッグ開始時のみデフォルトの動作を防ぐ
                var slider = $('#question_slider');
                var startY = e.pageY || e.originalEvent.touches[0].pageY; // タッチイベントに対応
                var startHeight = slider.height();

                // ドラッグ中に高さを調整
                $(document).on('mousemove.drag touchmove.drag', function(e) {
                    e.preventDefault(); // ドラッグ中のスクロールや他の動作を無効化
                    var moveY = e.pageY || e.originalEvent.touches[0].pageY;
                    var newHeight = startHeight - (moveY - startY);
                    if (newHeight >= 100 && newHeight <= $(window).height()) {
                        slider.height(newHeight);
                    }
                });

                // ドラッグが終了したらイベントを解除
                $(document).on('mouseup.drag touchend.drag', function() {
                    $(document).off('mousemove.drag touchmove.drag mouseup.drag touchend.drag');
                });
            });

            // フォームのクリックを有効にするため、フォームに影響しないようにイベントを解除
            $('#question_slider form').on('focus click', function(e) {
                e.stopPropagation(); // フォームにクリックやフォーカスが正しく伝播するようにする
            });
        });



    </script>
@endpush
@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header mb-3">
                <h2 class="section-title">{{ $offer->title }}</h2>
                <div class="row">
                    <div class="col-7 pe-0">申込締切：{{ $offer->application_deadline }}</div>
                    <div class="col-5 ps-0">募集人数：{{ $offer->recruit_number }}人</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('mypage.offer.apply',$offer->id) }}" class="btn btn-success w-50 d-block m-auto mb-3" role="button">案件に応募する</a>
                <a href="#" id="questions" class="btn btn-warning w-50 d-block m-auto mb-3" role="button">質 問 箱</a>
            </div>

            <dl class="d-flex flex-wrap px-1 mb-2 offer-detail">
                <dt class="w-25">案件種別</dt>
                <dd class="w-75">{{ $offer->biz_type }}</dd>
                <dt class="w-25">期 間</dt>
                <dd class="w-75">{{ $offer->duration }}</dd>
                <dt class="w-25">予 算</dt>
                <dd class="w-75">{{ $offer->budget }}</dd>
                <dt class="w-25">報酬種別</dt>
                <dd class="w-75">{{ $offer->offer_type }}</dd>
                <dt class="w-25">報 酬</dt>
                <dd class="w-75">{{ $offer->reward }}</dd>
                <dt class="w-25">内 容</dt>
                <dd class="w-75 text-area">{{ $offer->description }}</dd>
            </dl>
        </div>
    </div>

    <div id="question_slider">
        <div id="slider_tab"><i class="fa-solid fa-message"></i></div>
        <div class="slider_content container pt-3 mb-3">
            <form action="#" method="post" class="message-form">
                <div class="form-group mb-2">
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    <input type="hidden" name="artist_id" value="{{ $offer->id }}">
                    <label for="question">質問を入力して送信してください</label>
                    <input type="text" id="question" class="form-control" name="question">
                </div>
                <div class="form-group text-end">
                    <button type="submit" class="btn btn-secondary">送 信</button>
                </div>
                <div class="container">
                    <h3 class="section-title">質問履歴</h3>
                    <ul class="history row">
                        @foreach($messages as $message)
                        <li class="col-8">{{ $message->content}}</li>
                        <li class="col-4">{{ $message->created_at->format('Y-m-d') }}</li>
                        @endforeach
                    </ul>
                </div>
            </form>
        </div>



    </div>
@endsection
