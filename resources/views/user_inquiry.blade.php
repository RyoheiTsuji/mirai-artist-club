@extends('layouts.app')
@push('scripts')
@endpush
@section('content')
<div class="container my-5">
    <div class="card mx-auto">
        <div class="card-title">
            <h1 class="mb-4 section-title">問い合わせフォーム</h1>
        </div>
        <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <form action="{{ route('inquiry.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">お名前</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="affiliation" class="form-label">企業・事業所名</label>
            <input type="text" class="form-control" id="affiliation" name="affiliation" value="{{ old('affiliation') }}">
            @error('affiliation')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="affiliation" class="form-label">事業部</label>
            <input type="text" class="form-control" id="affiliation" name="division" value="{{ old('affiliation') }}">
            @error('affiliation')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inquiry_type" class="form-label">問い合わせの種別</label>
            <select class="form-select" id="inquiry_type" name="inq_type" required>
                <option value="" disabled selected>選択してください</option>
                @foreach(config('admin_setting.INQ_ABOUT') as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            @error('inquiry_type')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">件名</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
            @error('subject')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">問い合わせ内容</label>
            <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            @error('message')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">送信</button>
    </form>
        </div>
    </div>
</div>
@endsection

