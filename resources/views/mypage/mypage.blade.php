@extends('layouts.app_mypage')

@section('content')
    <h1 class="page_title">マイページ</h1>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="card">
                    <h2 class="section_title">プロフィール</h2>
                    <div class="myPhoto">
                        <img src="{{ asset('storage/' . $artist['photo_url']) }} ?? '#' }}" alt="アー写">
                        <ul class="controlBox">
                            <li><i class="fa-solid fa-cloud-arrow-up"></i></li>
                            <li><i class="fa-solid fa-pen-to-square"></i></li>
                        </ul>
                    </div>
                    <dl class="artist_info">
                        <dt>作家名</dt>
                        <dd>{{ $artist->name }}</dd>
                        <dt>作風</dt>
                        <dd></dd>
                        <dt>メールアドレス</dt>
                        <dd>{{ $artist->email }}</dd>
                        <dt>住所</dt>
                        <dd>
                            〒{{ $artist->postal_code ?? '' }}<br>
                            {{ $artist->address ?? '登録がありません' }}
                        </dd>
                        <dt>生年月日</dt>
                        <dd>{{ $artist->birthday ?? '登録がありません' }}</dd>
                        <dt>電話番号</dt>
                        <dd>{{ $artist->phone_number ?? '登録がありません' }}</dd>
                    </dl>
                    <dl class="artist_detail">
                        <dt>P R</dt>
                        <dd>{{ $artist->pr_statement ?? '登録がありません' }}</dd>
                        <dt>バイオグラフィ</dt>
                        <dd>{{ $artist->bio ?? '登録がありません' }}</dd>
                    </dl>
                    <p>ポートフォリオURL：<a href="{{ asset('storage/' . $artist['portfolio_pdf']) }} " class="btn btn-secondary">ダウンロード</a></p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <form action="{{ route('portfolio.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="portfolio" class="form-label">ポートフォリオPDFをアップロード</label>
                        <input class="form-control" type="file" id="portfolio" name="portfolio" accept="application/pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">アップロード</button>
                </form>
            </div>

            <div class="col-12 mt-4">
                <h2 class="section_title">作品一覧</h2>
                @if($artist->artworks->isEmpty())
                    <p>登録された作品がありません。</p>
                @else
                    <ul id="artwork_area" class="list-unstyled d-flex flex-row flex-wrap">
                        @foreach($artist->artworks as $artwork)
                            <li class="">
                                <strong>{{ $artwork->title }}</strong> ({{ $artwork->year }})<br>
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" style="max-width: 100px;">
                                <p>{{ $artwork->description }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
@endsection
