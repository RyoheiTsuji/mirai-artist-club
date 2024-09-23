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
        <p>現在の登録作品数：{{ $parentCount ?? 0 }}/3件</p>

@if( $parentCount < 3 )
    <a href="{{ route('mypage.art.create') }}" class="btn btn-primary">新しい作品を登録</a>
@else
    作品画像登録の上限です。新規作品は現在登録できません。
@endif

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(!$artworks || $artworks->isEmpty())
            <p>現在作品は登録されていません。</p>
        @else
            <div class="container mt-3">
                @foreach($artworks->where('parent_id', null) as $artwork)
                    <div class="row mb-4 artwork_container card">
                        <!-- 上段: メイン画像 -->
                        <div class="col-12">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="img-fluid">
                            <dl class="artwork-detail row">
                                <dt class="col-4">title</dt>
                                <dd class="col-8">{{ $artwork->title }}</dd>
                                <dt class="col-4">material</dt>
                                <dd class="col-8">{{ $artwork->material }}</dd>
                                <dt class="col-4">size</dt>
                                <dd class="col-8">
                                @if($artwork->size_o)
                                    {{ $artwork->size_w }}
                                @elseif($artwork->size_d)
                                    高さ：{{ $artwork->size_h }}cm / 幅：{{ $artwork->size_w }}cm / 奥行：{{ $artwork->size_d }}cm
                                @else
                                    縦：{{ $artwork->size_h }}cm / 横：{{ $artwork->size_w }}cm
                                @endif
                                </dd>
                                <dt class="col-4">tag</dt>
                                <dd class="col-8">
                                    @foreach($tags as $tag)
                                        <span class="col-4">{{ $tag->name }}</span>
                                    @endforeach
                                </dd>
                                <dt class="col-4">description</dt>
                                <dd class="col-8">
                                    {!! nl2br(e($artwork->description)) !!}
                                </dd>
                                <dt class="col-4">sales status</dt>
                                <dd class="col-8">
                                    @php
                                        $saleTypes = config('admin_setting.SALE_TYPES'); // SALE_TYPESを取得
                                        $sales = json_decode($artwork->sale); // JSON形式で保存されている場合
                                    @endphp
                                    @foreach($sales as $sale)
                                        {{ $saleTypes[$sale] ?? '不明' }}@if (!$loop->last), @endif
                                    @endforeach
                                </dd>
                                <dt class="col-4">pulic status</dt>
                                <dd class="col-8">{{ $artwork->proved ? '承認' : '未承認' }}</dd>
                            </dl>
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
                            <a href="{{ route('mypage.art.edit', ['id' => $artwork->id]) }}" class="btn btn-secondary">変更・修正</a>
                            <a href="{{ route('mypage.art.delete', ['id' => $artwork->id]) }}" class="btn btn-danger">削 除</a>
                            <a href="{{ route('mypage.art.sub_image', ['id' => $artwork->id]) }}" class="btn btn-success">サブ画像登録</a>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
@endsection
