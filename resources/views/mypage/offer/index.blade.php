@extends('layouts.app_mypage')

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav_offer a').addClass('active');
        });
    </script>
@endpush
@section('content')
    <div class="container mt-3">

        <div class="card mb-3">
            <h2 class="section_title mb-3">応募出来る案件一覧</h2>
            <dl class="offer-list row">
                <dt class="col-8 text-center border-bottom offer-title mb-2">案件名</dt>
                <dd class="col-4 text-center border-bottom offer-title mb-2">締切日</dd>
                @foreach($offers as $offer)
                    <dt class="col-8 ps-2"><a href="{{ route('mypage.offer.detail', $offer->id) }}" class="text-muted me-2">{{ $offer->title }}</a></dt>
                    <dd class="col-4 text-center">{{ $offer->application_deadline }}</dd>
                @endforeach
            </dl>
        </div>

    </div>
@endsection

