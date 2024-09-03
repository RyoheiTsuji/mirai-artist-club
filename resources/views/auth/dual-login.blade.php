@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:5rem;">
        <h2 class="page-title">Login</h2>

        <div class="row">
            <!-- Admin Login Form -->
            <div class="col-md-6 mt-4">
                <h3 class="section_title">管理画面</h3>
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="admin-email" class="form-label">Email</label>
                        <input type="email" name="email" id="admin-email" class="form-control" required>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="admin-password" class="form-label">Password</label>
                        <input type="password" name="password" id="admin-password" class="form-control" required>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Login as Admin</button>
                </form>
            </div>

            <!-- Artist Login Form -->
            <div class="col-md-6 mt-4">
                <h3>マイページ</h3>
                <form method="POST" action="{{ route('artist.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="artist-email" class="form-label">Email</label>
                        <input type="email" name="email" id="artist-email" class="form-control" required>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="artist-password" class="form-label">Password</label>
                        <input type="password" name="password" id="artist-password" class="form-control" required>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Login as Artist</button>
                </form>
            </div>
        </div>
    </div>
@endsection
