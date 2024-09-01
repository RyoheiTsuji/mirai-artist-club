@extends('layouts.app')

@section('content')
    <h1>エラー: セッションタイムアウト</h1>
    <p>{{ session('error') }}</p>
    <p>もう一度<a href="{{ session('redirect_url') }}">こちら</a>からログインしてください。</p>
@endsection
