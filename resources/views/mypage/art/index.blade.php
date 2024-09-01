@extends('layouts.app')

@section('content')
    <h1>登録作品一覧</h1>
    <a href="{{ route('mypage.art.create') }}" class="btn btn-primary">新しい作品を登録</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(!$artworks || $artworks->isEmpty())
        <p>登録されている作品がありません。</p>
    @else
        <ul>
            @foreach($artworks as $artwork)
                <li>
                    <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" width="300">
                    <p>{{ $artwork->title }} ({{ $artwork->year }})</p>
                    <p>{{ $artwork->size }}</p>
                    <p>{{ $artwork->description }}</p>
                    <p>{{ $artwork->proved ? '承認' : '未承認' }}</p>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
