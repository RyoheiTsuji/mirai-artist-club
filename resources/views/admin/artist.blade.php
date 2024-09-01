@extends('layouts.app_admin')
@push('description')
    //
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('membersChart').getContext('2d');

            // Laravelコントローラから渡されたデータをJavaScriptに渡す
            var labels = Object.values(@json($months->toArray()));
            var data = Object.values(@json($chartData->toArray()));
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels, // X軸のラベル（年月）
                    datasets: [{
                        label: '会員数の推移',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        data: data, // Y軸のデータ
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            reverse: true // X軸を反転させる
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
@section('content')
    <div id="content_wrapper">
        <h2 class="page-title" id="page_title">アーティスト管理</h2>
        <main class="row">
            <div class="col-6">
                <h3 class="content-title">お知らせ</h3>
                <ul>
                    <li><a href="#">未対応の"作品承認"があります</a></li>
                    <li><a href="#">未対応の"購入申込"があります</a></li>
                    <li><a href="#">未対応の"作家問い合わせ"があります</a></li>
                    <li><a href="#">”作家問い合わせ”に返信があります</a></li>
                </ul>
            </div>
            <div class="col-6">
                <h3 class="content-title">統計情報</h3>
                <canvas id="membersChart"></canvas>
            </div>

            <div class="col-12 row">
                <h3 class="content-title">登録作家一覧</h3>

                <div class="mb-3 mt-3 mb-5">
                    <h4 class="area-title" id="search_area">[検索エリア]</h4>
                    <form action="{{ route('admin.artist') }}" method="GET" class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="キーワードで検索">
                        </div>
                        <div class="col-md-3">
                            <select name="tag_id" class="form-select">
                                <option value="">全てのタグ</option>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">絞り込む</button>
                            <a href="{{ request()->fullUrlWithQuery(['order' => 'asc']) }}" class="btn btn-link">昇順</a>
                            <a href="{{ request()->fullUrlWithQuery(['order' => 'desc']) }}" class="btn btn-link">降順</a>
                        </div>
                    </form>
                </div>

                <div class="d-flex flex-wrap">
                @foreach($artists as $artist)
                    <div class="artist_frame">
                        <img src="{{ asset('storage/' . $artist['photo_url']) }}" alt="{{ $artist['name'] }}" width="260">
                        <table>
                            <tr>
                                <th>名前</th>
                                <td>{{ $artist['name'] }}</td>
                                <th>年齢</th>
                                <td>{{ $artist['age'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    @foreach($artist['tags'] as $tag)
                                        <span class="tagname">{{ $tag }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">PR</th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    {{ $artist['pr_statement'] }}
                                </td>
                            </tr>
                        </table>
                        <div class="button-container">
                            <a href="{{ route('admin.artist.detail', ['id' => $artist['id']]) }}" class="btn btn-primary full-width-btn">詳細ページ</a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

        </main>

<!--    ヒントウィンドウセクション    -->
        <div id="hints_window">
            <span id="toggle_hint"><i class="fa-solid fa-circle-up"></i></span>
            <div id="hints_content">
                <h2>Hint Window</h2>
                <section class="hint_article" data-target="page_title" style="display:none">
                    このページでは作家に関する様々な管理を行えます。
                    <dl>
                        <dt>・作家検索：</dt><dd>登録されている作家を検索出来ます。</dd>
                        <dt>・作品承認：</dt><dd>作家が公開を希望する作品の承認ができます。</dd>
                        <dt>・メッセージ管理：</dt><dd>作家が公開を希望する作品の承認ができます。</dd>
                        <dt>・作品承認：</dt><dd>作家が公開を希望する作品の承認ができます。</dd>
                    </dl>
                </section>
                <section class="hint_article" data-target="membersChart" style="display:none">
                    <p>任意の集計可能な統計を出すことが出来ます。</p>
                    <p>現在は月ごとの会員登録数を折れ線グラフで出しています。</p>
                </section>
                <section class="hint_article" data-target="search_area" style="display:none">
                    <p>検索エリアです。</p>
                    <p>作家の検索ができます。</p>
                    <p>検索ロジックは、作家の全登録内容からキーワードで全件検索をあいまい検索してタグで絞り込みをかける流れです。</p>
                    <p>キーワードだけでもタグだけでも検索ができます。</p>
                </section>
            </div>
        </div>
<!--  ヒントウィンドウセクションここまで　-->
    </div>

@endsection
