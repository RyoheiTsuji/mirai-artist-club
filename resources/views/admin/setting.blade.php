@extends('layouts.app_admin')

@section('content')
    <div id="content_wrapper">
        <h2 class="page-title" id="page_title">設定画面</h2>
        <main class="row mt-5">
            <div class="col-6">
                <div class="settingMenu">
                    <div>
                    <h3>管理者登録</h3>
                    <p>管理者を追加します。名前とパスワードとメールアドレスを入力し登録してください。</p>
                    <p>現在の管理者数: {{ $adminCount }}</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.RegAdmin') }}" method="post" title="新規管理者登録">
                        @csrf
                        <div class="mb-3">
                            <label for="name">名前</label>
                            <input name="name" id="name" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">メールアドレス</label>
                            <input name="email" id="email" type="email" class="form-control" required>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password">パスワード</label>
                            <input name="password" id="password" type="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation">パスワード確認</label>
                            <input name="password_confirmation" id="password_confirmation" class="form-control" type="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">登録</button>
                    </form>
                    </div>
                    <div class="mt-4 row">
                        <h3>管理者削除</h3>
                        <form action="{{ route('admin.deleteAdmin') }}" method="post">
                            @csrf
                            @foreach ($admins as $admin)
                                <div class="mt-3 mb-2 col-6">
                                    <input type="checkbox" name="admin_id[]" value="{{ $admin->id }}">
                                    <label>{{ $admin->name }}</label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-danger mt-2">削除</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-6">
                <div>
                    <div class="settingMenu">
                        <h3>作風管理</h3>
                        <p>登録済みの作風の数: {{ $tagCount }}</p>
                        <p>
                            作風の管理をします。<br>
                            作風とコメントの登録・削除、順番の並べ替えができます。
                        </p>

                        <a href="{{ route('tags.create') }}" title="タグの管理画面へすすむ" >>>タグ管理</a>
                    </div>
                    <div class="settingMenu">
                        <h3>SEO設定</h3>
                        <p>管理画面、マイページ関連以外のページ(固定ページ含む)のSEO設定を行います。</p>
                        <p>この設定画面ではheadタグ内のtitle,descriptionなどのmetaタグをページごとに編集します。</p>
                        <a href="#" title="SEO設定へすすむ" >>>SEO設定</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
