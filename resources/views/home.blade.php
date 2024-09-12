@extends('layouts.app')
@push('scripts')
@endpush
@section('content')
    <div class="contents">
        <div class="row">
        <h3 class="section_title">Login</h3>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-3 col-md-6">
                <label for="admin-email" class="form-label">Email</label>
                <input type="email" name="email" id="admin-email" class="form-control" required>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="admin-password" class="form-label">Password</label>
                <input type="password" name="password" id="admin-password" class="form-control" required>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">管理画面にログイン</button>
        </form>
            <p>
                管理画面へのログインは正式なURLに移動<br>
                <a href="{{ route('admin.dashboard') }}">変更先URL {{ route('admin.dashboard') }}</a>もしくは<a href="{{ route('admin.login') }}">{{ route('admin.login') }}</a>
            </p>
        </div>

    </div>
@endsection
