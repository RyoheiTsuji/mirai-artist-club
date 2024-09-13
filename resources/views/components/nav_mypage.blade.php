<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <ul class="nav d-flex justify-content-between w-100">
            <li class="nav-item"  id="nav_profile">
                <a class="nav-link" href="{{ route('mypage.profile') }}">
                    <i class="fa-solid fa-address-card"></i>
                    <span class="menu_title">profile</span>
                </a>
            </li>
            <li class="nav-item" id="nav_artwork">
                <a class="nav-link" href="{{ route('mypage.art.index') }}">
                    <i class="fa-solid fa-image"></i>
                    <span class="menu_title">
                        artworks
                    </span>
                </a>
            </li>
            <li class="nav-item" id="nav_offer">
                <a class="nav-link" href="{{ route('mypage.offer') }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span class="menu_title">
                        offers
                    </span>
                </a>
            </li>
            <li class="nav-item" id="nav_comment">
                <a class="nav-link" href="{{ route('mypage.comment') }}">
                    <i class="fa-regular fa-comment-dots"></i>
                    <span class="menu_title">comments</span>
                </a>
            </li>
            <li class="nav-item" id="nav_inquiry">
                <a class="nav-link" href="{{ route('mypage.inquiry') }}">
                    <i class="fa-solid fa-inbox"></i>
                    <span class="menu_title">inquiry</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

