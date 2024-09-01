@extends('layouts.app_admin')
@push('description')
    //
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@section('content')
    <div class="container">
        <h1>{{ $artist->name }} の詳細</h1>

        <div class="artist-details">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $artist->photo_url) }}" alt="{{ $artist->name }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th>名前</th>
                            <td>{{ $artist->name }}</td>
                        </tr>
                        <tr>
                            <th>年齢</th>
                            <td>{{ $age }}歳</td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>{{ $artist->email }}</td>
                        </tr>
                        <tr>
                            <th>住所</th>
                            <td>{{ $artist->address }}</td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>{{ $artist->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>タグ</th>
                            <td>
                                @foreach($artist->tags as $tag)
                                    <span class="tagname">{{ $tag->name }}</span>
                                @endforeach
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
            <h2 class="page-title">登録された作品</h2>
            <div class="artworks row">
                @php
                    $mainArtworks = $artist->artworks->where('parent_id', null);
                @endphp
                @foreach($mainArtworks as $artwork)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" class="card-img-top" alt="{{ $artwork->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $artwork->title }}</h5>
                                <p class="card-text">{{ $artwork->description }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>制作年:</strong> {{ $artwork->year }}</li>
                                    <li class="list-group-item"><strong>サイズ:</strong> {{ $artwork->size }}</li>
                                </ul>

                                @php
                                    $childArtworks = $artist->artworks->where('parent_id', $artwork->id);
                                @endphp

                                @if($childArtworks->isNotEmpty())
                                    <h6>子画像:</h6>
                                    <div class="child-thumbnails">
                                        @foreach($childArtworks as $index => $childArtwork)
                                            <img src="{{ asset('storage/' . $childArtwork->image_path) }}" alt="{{ $childArtwork->title }}"
                                                 class="img-thumbnail child-img" data-bs-toggle="modal"
                                                 data-bs-target="#childArtworkModal{{ $artwork->id }}"
                                                 data-bs-slide-to="{{ $index }}">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- モーダル -->
                    <div class="modal fade" id="childArtworkModal{{ $artwork->id }}" tabindex="-1" aria-labelledby="childArtworkModalLabel{{ $artwork->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="childArtworkModalLabel{{ $artwork->id }}">サブ画像</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="carouselChildArtwork{{ $artwork->id }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($childArtworks as $index => $childArtwork)
                                                <div class="carousel-item {{ $index === 1 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $childArtwork->image_path) }}" class="d-block w-100" alt="{{ $childArtwork->title }}">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h5>{{ $childArtwork->title }}</h5>
                                                        <p>{{ $childArtwork->description }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselChildArtwork{{ $artwork->id }}" role="button" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">前へ</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselChildArtwork{{ $artwork->id }}" role="button" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">次へ</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-6">
                    <table class="table" title="PR文など">
                        <tr>
                            <th>バイオグラフィー</th>
                        </tr>
                        <tr>
                            <td>{{ $artist->bio }}</td>
                        </tr>
                        <tr>
                            <th>PRステートメント</th>
                        </tr>
                        <tr>
                            <td>{{ $artist->pr_statement }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table" title="受賞歴">
                        <tr>
                            <th>1999年</th>
                            <td>二科展入賞</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin.artist') }}" class="btn btn-secondary">戻る</a>
        </div>
    </div>
@endsection
