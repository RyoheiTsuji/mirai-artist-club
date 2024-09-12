@extends('layouts.app_admin')
@push('description')
    //
@endpush
@push('scripts')
    <script>
        // PHPからJavaScriptにデータを渡す
        let selectedArtists = {};

        @if(isset($offer->artists))
                @foreach($offer->artists as $artist)
            selectedArtists[{{ $artist->id }}] = {
            name: '{{ $artist->name }}',
            tags: '{!! implode(", ", $artist->tags->pluck('name')->toArray()) !!}',
            levelClass: 'level-{{ $artist->level }}'
        };
        @endforeach
        @endif
    </script>


@endpush
@php
    $offerTypes = config('admin_setting.OFFER_TYPES');
@endphp

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h2 class="mb-4 page-title">新しい案件を作成</h2>

        <!-- 案件作成フォーム -->
            <form id="offerForm" action="{{ isset($offer) ? route('admin.offer.update', $offer->id) : route('admin.offer.store') }}" method="POST">
                @csrf
                @if(isset($offer))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="offer_type" class="form-label">案件タイプ<span class="required-label">必須</span></label><br>
                    <select id="offer_type" name="offer_type" class="form-select">
                        <option value="" disabled {{ old('offer_type', $offer->offer_type ?? '') == '' ? 'selected' : '' }}>選択してください</option>
                        @foreach($offerTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('offer_type', $offer->offer_type ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">案件タイトル<span class="required-label">必須</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $offer->title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">案件期間</label>
                    <input type="text" class="form-control" id="duration" name="duration" placeholder="例: 3ヶ月 または 5月1日～6月30日" value="{{ old('duration', $offer->duration ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="recruit_number" class="form-label">募集人数</label>
                    <input type="number" class="form-control" id="recruit_number" name="recruit_number" min="1" value="{{ old('recruit_number', $offer->recruit_number ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="budget" class="form-label">予算</label>
                    <input type="number" class="form-control" id="budget" name="budget" placeholder="金額を入力" value="{{ old('budget', $offer->budget ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="application_deadline" class="form-label">募集締切日</label>
                    <input type="date" class="form-control" id="application_deadline" name="application_deadline" value="{{ old('application_deadline', $offer->application_deadline ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="reward" class="form-label">報酬</label>
                    <input type="text" class="form-control" id="reward" name="reward" placeholder="報酬の内容を入力" value="{{ old('reward', $offer->reward ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="biz_type" class="form-label">収入形態</label>
                    <textarea class="form-control" id="biz_type" name="biz_type" rows="2" placeholder="収入形態を入力" required>{{ old('biz_type', $offer->biz_type ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="collab_with" class="form-label">コラボ相手</label>
                    <select class="form-select" id="collab_with" name="collab_with" required>
                        <option value="" disabled {{ old('collab_with', $offer->collab_with ?? '') == '' ? 'selected' : '' }}>選択してください</option>
                        <option value="partner1" {{ old('collab_with', $offer->collab_with ?? '') == 'partner1' ? 'selected' : '' }}>パートナー1</option>
                        <option value="partner2" {{ old('collab_with', $offer->collab_with ?? '') == 'partner2' ? 'selected' : '' }}>パートナー2</option>
                        <option value="partner3" {{ old('collab_with', $offer->collab_with ?? '') == 'partner3' ? 'selected' : '' }}>パートナー3</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">内容 <span class="required-label">必須</span></label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="案件の詳細内容を入力" required>{{ old('description', $offer->description ?? '') }}</textarea>
                </div>

                <!-- 選択された作家が表示されるエリア -->
                <div class="mt-3">
                    <h4>案件を送る作家</h4>
                    <div class="border p-3">
                        <ul class="list-group d-flex flex-row flex-wrap justify-content-between " id="selectedArtists">
                            <!-- 検索結果で選択された作家がここに表示されます -->
                            @if(isset($offer->artists))
                                @foreach($offer->artists as $artist)
                                    <li class="list-group-item">
                                        {{ $artist->name }} <button type="button" class="btn btn-danger btn-sm ms-auto remove-artist" data-id="{{ $artist->id }}">削除</button>
                                        <input type="hidden" name="selected_artists[]" value="{{ $artist->id }}">
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">{{ isset($offer) ? '案件を更新' : '案件を作成' }}</button>
                </div>
            </form>


            <!-- 作家検索フォーム -->
        <!-- 作家検索フィルタ -->
        <h3 class="mt-5">送付先の作家を検索</h3>
        <div class="p-4 rounded shadow-sm bg-light">
            <h5 class="mb-4">アーティスト検索フィルター</h5>

            <div class="row g-3 align-items-center">
                <!-- 作家レベルで絞り込み -->
                <div class="col-md-3">
                    <label for="level" class="form-label fw-bold">作家レベル</label>
                    <select class="form-select" id="level" name="level">
                        <option value="" selected>選択してください</option>
                        <option value="1">レベル 1</option>
                        <option value="2">レベル 2</option>
                        <option value="3">レベル 3</option>
                    </select>
                </div>

                <!-- 作風カテゴリで絞り込み -->
                <div class="col-md-4">
                    <label for="tag" class="form-label fw-bold">作風カテゴリ</label>
                    <select class="form-select" id="tag" name="tag">
                        <option value="" selected>選択してください</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- フリーワードで絞り込み -->
                <div class="col-md-3">
                    <label for="keyword" class="form-label fw-bold">フリーワード</label>
                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="作家名、作品名など">
                </div>

                <!-- ボタン -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="searchButton" class="btn btn-primary w-100">絞り込む</button>
                </div>
            </div>
        </div>

        <!-- 検索結果の表示 -->
        <div class="mt-3">
            <h4>検索結果</h4>
            <button type="button" id="selectAll" class="btn btn-secondary mb-2">全件チェック</button>
            <ul class="list-group d-flex flex-wrap flex-row justify-content-between " id="searchResults">
                <!-- 検索結果はここに表示されます -->
            </ul>
        </div>
    </div>
@endsection
