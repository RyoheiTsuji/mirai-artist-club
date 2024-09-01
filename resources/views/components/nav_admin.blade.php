@php
    use Illuminate\Support\Str;
@endphp

<nav class="navbar navbar-expand-lg flex-column">
    <ul id="side-nav" class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">ダッシュボード</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.artist') ? 'active' : '' }}" href="{{ route('admin.artist') }}">アーティスト管理</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.offer') ? 'active' : '' }}" href="{{ route('admin.offer') }}">案件管理</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.inquiry') ? 'active' : '' }}" href="{{ route('admin.inquiry') }}">問合せ管理</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.message') ? 'active' : '' }}" href="{{ route('admin.message') }}">メッセージ管理</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.catalogue') ? 'active' : '' }}" href="{{ route('admin.catalogue') }}">カタログ作成</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.sales') ? 'active' : '' }}" href="{{ route('admin.sales') }}">売買管理</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.notice') ? 'active' : '' }}" href="{{ route('admin.notice') }}">サイトお知らせ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.page') ? 'active' : '' }}" href="{{ route('admin.page') }}">ページ管理</a>
        </li>
    </ul>
</nav>

