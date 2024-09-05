<?php

namespace App\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MypageProfileController extends Controller
{
    public function photoUpload(Request $request)
    {
        // バリデーション
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MBまでの画像ファイルを許可
        ]);

        // 現在のユーザーを取得
        $artist = Auth::user();

        // 既存の画像を削除（必要であれば）
        if ($artist->photo_url) {
            Storage::disk('public')->delete($artist->photo_url);
        }

        // 新しい画像を保存
        $path = $request->file('image')->store('artist_photo', 'public');
        if (!$path) {
            return response()->json(['success' => false, 'message' => '画像の保存に失敗しました。']);
        }

        $artist->photo_url = $path;
        $artist->save();

        // クライアントにレスポンスを返す
        return response()->json(['success' => true, 'photo_url' => Storage::url($path)]);
    }

    public function updateProfile(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // 現在のユーザーを取得
        $artist = Auth::user();

        // プロフィール情報の更新
        $artist->name = $request->input('name');
        $artist->bio = $request->input('bio');
        $artist->save();

        // クライアントにレスポンスを返す
        return response()->json(['success' => true, 'message' => 'プロフィールが更新されました。']);
    }
}

