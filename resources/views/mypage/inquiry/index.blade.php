@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_inquiry a').addClass('active');
        });
    </script>
@endpush
@section('content')
    <div class="content">
        <h1 class="page_title">問い合わせ管理</h1>
        <a href="{{ route('mypage.inquiry.create') }}" class="btn btn-primary">新しい作品を登録</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
