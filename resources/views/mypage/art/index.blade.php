@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_artwork a').addClass('active');
        });
    </script>
@endpush

@section('content')
    <div class="container mt-3">
        <h1 class="page_title">登録作品一覧</h1>
        <p>現在の登録作品数：{{ $parentCount  }}件</p>

@if( $parentCount < 3 )
    <a href="{{ route('mypage.art.create') }}" class="btn btn-primary">新しい作品を登録</a>
@else
    <a href="{{ route('mypage.art.create') }}" class="btn btn-primary">お腹いっぱい</a>
@endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(!$artworks || $artworks->isEmpty())
            <p>現在作品は登録されていません。</p>
        @else
            <div class="container mt-5">
                @foreach($artworks->where('parent_id', null) as $artwork)
                    <div class="row mb-4 artwork_container card">
                        <!-- 上段: メイン画像 -->
                        <div class="col-12">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="img-fluid">
                            <p>{{ $artwork->title }}</p>
                            <p>{{ $artwork->material }}</p>
                            <p>縦：{{ $artwork->size_h }}cm / 横：{{ $artwork->size_w }}cm</p>
                            <p>{{ $artwork->description }}</p>
                            <!-- 販売状況の表示 -->
                            @php
                                $saleTypes = config('admin_setting.SALE_TYPES'); // SALE_TYPESを取得
                                $sales = json_decode($artwork->sale); // JSON形式で保存されている場合
                            @endphp
                            @if($sales)
                                <p>販売状況:
                                    @foreach($sales as $sale)
                                        {{ $saleTypes[$sale] ?? '不明' }}@if (!$loop->last), @endif
                                    @endforeach
                                </p>
                            @endif
                            <div class="row">
                                @foreach($tags as $tag)
                                <span class="col-4">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            <p>{{ $artwork->proved ? '承認' : '未承認' }}</p>
                        </div>

                        <!-- 下段: サブ画像 -->
                        <div class="col-12 row">
                            @foreach($artworks->where('parent_id', $artwork->id)->take(2) as $subArtwork)
                                <div class="mb-3 col-6">
                                    <img src="{{ asset('storage/' . $subArtwork->image_path) }}" alt="{{ $subArtwork->title }}" class="img-fluid">
                                    <p>{{ $subArtwork->title }} ({{ $subArtwork->year }})</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('mypage.art.edit', ['id' => $artwork->id]) }}" class="btn btn-secondary">メイン画像 変更・修正</a>
                            <a href="{{ route('mypage.art.sub_image', ['id' => $artwork->id]) }}" class="btn btn-secondary">サブ画像登録</a>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
@endsection
