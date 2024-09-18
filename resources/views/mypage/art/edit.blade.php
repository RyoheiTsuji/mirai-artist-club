@extends('layouts.app_mypage')
@push('scripts')
    <script>
        $(document).ready(function(){
        $('#nav_artwork a').addClass('active');
        });
    </script>
@endpush
@section('content')
<div class="content">
    <h1 class="page_title">登録画像編集</h1>

    <div class="card main_image artwork_container mt-4">
        <p>ステータス:{{ $artwork->proved ? '承認' : '未承認' }}</p>
        <div class="imgArea">
            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="">
            <div class="imgTitle row">
                <span class="col-8">{{ $artwork->title }}</span>
                <span class="col-4">{{ $artwork->year }}年</span>
            </div>
        </div>
        <div class="infoArea">
            <dl class="row">
                <dt class="col-4">サイズ：</dt>
                <dd class="col-8">{{ $artwork->size }}</dd>
                <dt class="col-4">詳細：</dt>
                <dd class="col-8">{{ $artwork->description }}</dd>
            </dl>
        </div>
    </div>
    @foreach($artwork->children as $subArtwork)
    <div class="card sub_image artwork_container mt-4">
        <div class="imgArea">
            <img src="{{ asset('storage/' . $subArtwork->image_path) }}" alt="">
            <div class="imgTitle row">
                <span class="col-8">{{ $subArtwork->title }}</span>
                <span class="col-4">{{ $subArtwork->year }}年</span>
            </div>
        </div>
        <div class="infoArea">
            <dl class="row">
                <dt class="col-4">サイズ：</dt>
                <dd class="col-8">{{ $subArtwork->size }}</dd>
                <dt class="col-4">詳細：</dt>
                <dd class="col-8">{{ $subArtwork->description }}</dd>
            </dl>
        </div>
    </div>
    @endforeach

</div>
@endsection
