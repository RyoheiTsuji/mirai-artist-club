<header id="header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                {{ config('app.name', 'Mirai Artist Club') }}
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
                        5
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
