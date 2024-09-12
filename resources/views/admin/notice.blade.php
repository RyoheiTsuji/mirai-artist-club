@extends('layouts.app_admin')

@section('content')
    <div id="content_wrapper">
        <h2 class="page-title" id="page_title">お知らせ一覧</h2>

        <!-- 新規作成ページへのリンク -->
        <a href="{{ route('admin.notice.create') }}" class="btn btn-primary mb-4">
            <i class="fas fa-plus-circle"></i> 新規お知らせ作成
        </a>

        <!-- お知らせ一覧 -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>タイトル</th>
                <th>登録日</th>
                <th>掲載期間</th>
                <th>ステータス</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($announcements as $announcement)
                @if (now()->between($announcement->publish_start_date, $announcement->publish_end_date))
                    <!-- 掲載中 -->
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($announcement->publish_start_date)
                                {{ \Carbon\Carbon::parse($announcement->publish_start_date)->format('Y-m-d') }}
                            @else
                                開始日未設定
                            @endif
                            〜
                            @if($announcement->publish_end_date)
                                {{ \Carbon\Carbon::parse($announcement->publish_end_date)->format('Y-m-d') }}
                            @else
                                終了日未設定
                            @endif
                        </td>
                        <td><span class="badge bg-success">掲載中</span></td>
                    </tr>
                @elseif (now()->isBefore($announcement->publish_start_date))
                    <!-- 未掲載 -->
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($announcement->publish_start_date)
                                {{ \Carbon\Carbon::parse($announcement->publish_start_date)->format('Y-m-d') }}
                            @else
                                開始日未設定
                            @endif
                            〜
                            @if($announcement->publish_end_date)
                                {{ \Carbon\Carbon::parse($announcement->publish_end_date)->format('Y-m-d') }}
                            @else
                                終了日未設定
                            @endif
                        </td>
                        <td><span class="badge bg-warning">未掲載</span></td>
                    </tr>
                @else
                    <!-- 掲載終了 -->
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->created_at->format('Y-m-d') }}</td>
                        @if(\Carbon\Carbon::hasFormat($announcement->publish_start_date, 'Y-m-d'))
                            {{ \Carbon\Carbon::parse($announcement->publish_start_date)->format('Y-m-d') }}
                        @else
                            開始日未設定
                        @endif
                        〜
                        @if(\Carbon\Carbon::hasFormat($announcement->publish_end_date, 'Y-m-d'))
                            {{ \Carbon\Carbon::parse($announcement->publish_end_date)->format('Y-m-d') }}
                        @else
                            終了日未設定
                        @endif
                        <td><span class="badge bg-secondary">掲載終了</span></td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="4">お知らせがありません。</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
