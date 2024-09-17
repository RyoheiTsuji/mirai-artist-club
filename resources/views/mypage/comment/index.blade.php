@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_comment a').addClass('active');
        });
    </script>
@endpush
@section('content')
    <div class="content">
        <h1 class="page_title">コメント管理</h1>
    </div>
@endsection
