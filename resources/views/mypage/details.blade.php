@extends('layouts.app')

@section('content')
    <h1>Mirai Artist Club会員本登録</h1>
    <div class="container">
        <p>{{ $name }}様 会員登録のお申し込みありがとうございます。</p>
        <p>以下のフォームから必要な情報を入力して、本登録を完了してください。</p>
        <h2>アーティスト本登録</h2>
        <form method="POST" action="{{ route('artist.details.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <input type="email" name="email" id="email" required value="{{ $email }}" hidden>
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">作風（タグ）</label>
                <div id="tags">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tags[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}">
                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('tags')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photo_url" class="form-label">プロフィール画像</label>
                <input type="file" name="photo_url" id="photo_url" class="form-control">
                @error('photo_url')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
@endsection
