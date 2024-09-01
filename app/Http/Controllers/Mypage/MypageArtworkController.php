<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MypageArtworkController extends Controller
{
    // 作品一覧表示
    public function index()
    {
        $artist = Auth::guard('artist')->user();
        $tags = $artist->tags;
        // アーティストが存在するか確認し、作品を取得
        if ($artist) {
            $artworks = $artist->artworks; // アーティストに紐づく作品を取得
        } else {
            $artworks = collect(); // アーティストが存在しない場合は空のコレクションを返す
        }

        return view('mypage.art.index', compact('artworks','tags'));
    }

    // 作品登録フォーム表示
    public function create()
    {
        $artist = Auth::guard('artist')->user();
        $tags = $artist->tags; // アーティストに紐づくタグを取得

        return view('mypage.art.create', compact('tags'));
    }

    // 作品登録処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer',
            'size' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // ファイルの保存
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '_' . $image->getClientOriginalName();
            $filePath = $image->storeAs('artworks', $fileName, 'public');
        }

        // 作品の登録
        $artwork = new Artwork([
            'artist_id' => Auth::guard('artist')->id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'year' => $request->input('year'),
            'size' => $request->input('size'),
            'image_path' => $filePath,
        ]);
        $artwork->save();

        // タグの保存
        $artwork->tags()->sync($request->input('tags'));


        Notification::create([
            'artist_id' => 0, // 管理者向けの通知なのでnullか0
            'type' => 'artwork_registered', // 通知の種類
            'data' => json_encode([
                'artwork_id' => $artwork->id,
                'artist_id' => $artwork->artist_id,
                'message' => '新しい作品が登録されました。',
            ]),
            'is_read' => false,
        ]);

        return redirect()->route('mypage.art.index')->with('success', '作品が登録されました。');
    }

}

