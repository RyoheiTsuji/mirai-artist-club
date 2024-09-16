<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('admin.notice', compact('announcements'));
    }

    public function create()
    {
        return view('admin.notice_create');
    }

    public function store(Request $request)
    {
        try {
            // バリデーション
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'event_start_date' => 'nullable|date',
                'event_end_date' => 'nullable|date',
                'publish_start_date' => 'nullable|date',
                'publish_end_date' => 'nullable|date',
                'calendar_flag' => 'boolean',
                'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            ]);

            // 画像がアップロードされた場合
            $photo_url = null;
            if ($request->hasFile('photo')) {
                $photo_url = $request->file('photo')->store('public/img/notice');
                $photo_url = Storage::url($photo_url);
            }

            // DBに登録
            Announcement::create([
                'user_id' => Auth::guard('admin')->id(),
                'user_type' => 0, // 管理者
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'event_start_date' => $validatedData['event_start_date'],
                'event_end_date' => $validatedData['event_end_date'],
                'publish_start_date' => $validatedData['publish_start_date'],
                'publish_end_date' => $validatedData['publish_end_date'],
                'calendar_flag' => $validatedData['calendar_flag'],
                'photo_url' => $photo_url,
                'content_type' => 0,
            ]);

            return redirect()->route('admin.notice')->with('success', 'お知らせが登録されました。');
        } catch (\Exception $e) {
            Log::error('お知らせ登録エラー: ' . $e->getMessage());
            return redirect()->back()->withErrors('お知らせの登録中にエラーが発生しました。');
        }
    }
}
