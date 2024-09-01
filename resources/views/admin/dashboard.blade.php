@extends('layouts.app_admin')

@section('content')
    <h1>管理画面ダッシュボード</h1>
    <p>作家登録人数：{{ $artistCount }}</p>
    <p>作風登録数：{{ $tagCount }}</p>
    <p>管理人数：{{ $adminCount }}</p>
@endsection
