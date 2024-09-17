@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_offer a').addClass('active');
        });
    </script>
@endpush
@section('content')
    <div class="content">
        <h1 class="page_title">案件一覧</h1>
    </div>
@endsection
