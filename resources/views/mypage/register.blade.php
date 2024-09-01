@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>新規登録</h2>
        <p>メールアドレスと名前を送信して入会手続きを始めます。</p>

        <form method="POST" action="{{ route('artist.register.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">名前</label>
                <input type="text" name="name" id="name" class="form-control" required>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">送信</button>
        </form>
    </div>
@endsection
