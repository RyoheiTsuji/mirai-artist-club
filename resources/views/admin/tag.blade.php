@extends('layouts.app_admin')
@push('description')

@endpush
@push('scripts')

@endpush
@section('content')
    <div id="content_wrapper">
        <h2 class="page-title" id="page_title">タグ管理</h2>
        <main class="row">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}yapopo</div>
                    @endforeach
                </div>
            @endif
            <div class="col-6 mt-4" id="tagreg">
                <h3 class="content-title">タグ（作風）登録</h3>
                <form method="POST" action="{{ route('tags.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tag_name" class="form-label">タグ名</label>
                        <input type="text" name="name" id="tag_name" class="form-control" value="{{ old('name') }}"
                               required>
                        @error('tag_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">説明</label>
                        <textarea name="description" id="description"
                                  class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">登録</button>
                </form>
            </div>
            <div class="col-6 mt-4" id="tagdel">
                <h3 class="content-title">タグ（作風）削除</h3>
                <form action="{{ route('tags.delete') }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach($tags as $tag)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tag_ids[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}">
                                    <label class="form-check-label" for="tag{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-danger mt-3">削除</button>
                </form>
            </div>
            <div class="col-12 mt-4" id="tagorder">
                <h3 class="content-title">順序入れ替え</h3>
                <form action="{{ route('tags.updateOrder') }}" method="POST">
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th>タグ名</th>
                            <th>説明</th>
                            <th>順序</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->description }}</td>
                                <td>
                                    <input type="number" name="orders[{{ $tag->id }}]" value="{{ $tag->tag_order }}" class="form-control" style="width: 80px;">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">順序を更新</button>
                </form>
            </div>
        </main>

        <!--    ヒントウィンドウセクション    -->
        <div id="hints_window">
            <span id="toggle_hint"><i class="fa-solid fa-circle-up"></i></span>
            <div id="hints_content">
                <h2>Hint Window</h2>
                <section class="hint_article" data-target="page_title" style="display:none">
                    このページではタグ（作風）に関する様々な管理を行えます。
                    <dl>
                        <dt>・タグ（作風）登録：</dt><dd>作家や作品に紐づくタグを登録出来ます。</dd>
                        <dt>・タグ（作風）削除：</dt><dd>作家が公開を希望する作品の承認ができます。</dd>
                        <dt>・順序入れ替え：</dt><dd>作家が公開を希望する作品の承認ができます。</dd>
                    </dl>
                </section>
                <section class="hint_article" data-target="tagreg" style="display:none">
                    <p>作家や作品に紐づくタグを登録するエリアです。</p>
                    <p>「説明」は作家が自身でタグ付けを行う際に表示される説明（作風定義）を入力するようにしてください。</p>
                </section>
                <section class="hint_article" data-target="tagdel" style="display:none">
                    <p>タグを削除するエリアです。</p>
                    <p>すでに誰かが削除しようとするタグを登録している場合、タグの登録データは全部消えます。<br>運営開始後 削除を行う際は注意を払ってください。</p>
                </section>
                <section class="hint_article" data-target="tagorder" style="display:none">
                    <p>タグの表示順を変更するエリアです。</p>
                    <p>順序にかぶりがないように順序の整合性に注意し登録してください。<br>被った場合はエラーがでます。</p>
                </section>
            </div>
        </div>
        <!--  ヒントウィンドウセクションここまで　-->


    </div>
@endsection
