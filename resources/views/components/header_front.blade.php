<header class="d-flex flex-wrap align-items-center justify-content-between pt-2 pb-0 mb-0 border-bottom">
    <!-- Left: Logo -->
    <div class="col-md-4 ms-5">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="{{ asset('storage/img/logo_w500.gif') }}" alt="Logo" class="login-logo">
        </a>
    </div>

    <!-- Right: Buttons and Menu -->

    <nav id="headerNav" class="col-md-6 d-flex justify-content-end align-items-center me-3">
        <button type="button" class="btn btn-outline-login me-3">ログイン</button>
        <button type="button" class="btn btn-login me-2">新規登録</button>
        <!-- Horizontal List (Menu) -->
        <ul id="navList" class="list-group list-group-horizontal mb-0">
            <li class="list-group-item border-0 p-2"><a href="#">ABOUT</a></li>
            <li class="list-group-item border-0 p-2"><a href="#">SEARCH <i class="fa-solid fa-magnifying-glass"></i></a></li>
            <li class="list-group-item border-0 p-2"><a class="" data-bs-toggle="collapse" href="#dropdownMenu" role="button">
                    MENU <i class="fas fa-bars"></i></a></li>
        </ul>
    </nav>


</header>
<div id="dropdownMenu" class="collapse">
    <ul class="list-group p-4">
        <li class="list-group-item py-3 border-0 border-bottom"><a href="#">Item 1</a></li>
        <li class="list-group-item py-3 border-0 border-bottom "><a href="#">Item 2</a></li>
        <li class="list-group-item py-3 border-0 "><a href="/inquiry">お問い合わせ</a></li>
    </ul>
</div>
