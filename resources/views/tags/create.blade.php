@extends('layouts.app_admin')
@push('description')

@endpush
@push('scripts')

@endpush
@section('content')
    <div class="container">
        <h2>タグ登録</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tags.store') }}">
            @csrf

            <div class="mb-3">
                <label for="tag_name" class="form-label">タグ名</label>
                <input type="text" name="name" id="tag_name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">説明</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
@endsection
