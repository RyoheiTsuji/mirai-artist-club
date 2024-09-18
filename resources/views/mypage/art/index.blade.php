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
        <a href="{{ route('mypage.art.create') }}" class="btn btn-primary">新しい作品を登録</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(!$artworks || $artworks->isEmpty())
            <p>残念ながら登録されている作品がありません。</p>
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
