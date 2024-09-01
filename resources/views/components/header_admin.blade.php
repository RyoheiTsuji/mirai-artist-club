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
                        login as: {{ Auth::guard('admin')->user()->name }}
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="#" title="通 知" id="notification-icon">
                            <i class="fas fa-bell"></i>
                        </a>
                        <span class="badge badge-pill badge-danger notification-badge">
                            {{ $notifications->count() }}
                        </span>

                        <!-- ドロップダウンメッセージ -->
                        <div class="dropdown-menu notifications-dropdown" id="notifications-dropdown">
                            @foreach($notifications as $notification)
                                @php
                                    $data = json_decode($notification->data, true);
                                @endphp
                                <a class="dropdown-item" href="#">
                                    {{ $data['artist_name'] ?? '不明なアーティスト' }}さんから{{ $data['message'] ?? '未対応の通知があります。' }}
                                </a>
                            @endforeach
                        </div>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.setting') }}" title="設 定"><i class="fas fa-wrench"></i></a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.logout') }}" title="ログアウト"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
