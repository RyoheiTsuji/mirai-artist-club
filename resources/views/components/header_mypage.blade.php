@if (Agent::isMobile())
    <header id="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route('artist.mypage') }}">
                    <img src="{{ asset('storage/img/logo_w500.gif') }}" alt="Logo" class="mypage_logo">
                </a>
                <div>
                    <ul class="nav admin_header_nav">
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="#" title="通 知" id="notification-icon">
                                <i class="fas fa-bell"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- ハンバーガーメニューのボタン -->
                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                                <i class="fas fa-bars"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasMenuLabel">MiraiArtistClub menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled">
                    <li><a href="#" class="nav-link">ミライアーティストクラブとは</a></li>
                    <li><a href="#" class="nav-link">アーティストへ提供できること</a></li>
                    <li><a href="#" class="nav-link">法人のお客さまへ提供できること</a></li>
                    <li><a href="#" class="nav-link">オンラインコンテンツ一覧</a></li>
                    <li><a href="#" class="nav-link">サイトガイド</a></li>
                    <li><a href="{{ route('artist.logout') }}" class="nav-link">ログアウト</a></li>
                </ul>
            </div>
        </div>
    </header>
@else
    <header id="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('storage/img/logo_w500.gif') }}" alt="Logo" class="mypage_logo">
                </a>
                <div>
                    <!-- 右側に配置するメニューやユーザー情報 -->
                    <ul class="nav admin_header_nav">
                        <li class="nav-item">
                            login as: {{ Auth::guard('artist')->user()->name }}
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="#" title="通 知" id="notification-icon">
                                <i class="fas fa-bell"></i>
                            </a>
                            <span class="badge badge-pill badge-danger notification-badge">
                        1
                        </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('artist.logout') }}" title="ログアウト"><i class="fas fa-sign-out-alt"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@endif
