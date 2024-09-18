<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $tags = Tag::orderBy('tag_order')->get();

        return view('mypage.art.create', compact('tags'));
    }

    // 作品登録処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'material' => 'required|string|max:255',
            'size_w' => 'required|integer',
            'size_h' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        //dd($request);

        // ファイルの保存
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = Str::random(10) . '_' . $image->getClientOriginalName();
            $filePath = $image->storeAs('artworks', $fileName, 'public');
        }

        // 作品の登録
        $artwork = new Artwork([
            'artist_id' => Auth::guard('artist')->id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'material' => $request->input('material'),
            'size_w' => $request->input('size_w'),
            'size_h' => $request->input('size_h'),
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
        if ($request->input('action') === 'sub_image') {
            return redirect()->route('mypage.art.sub_image', $artwork->id)->with('success', '作品が登録されました。サブ画像の登録へ進みます。');
        }
        return redirect()->route('mypage.art.index')->with('success', '作品が登録されました。');
    }

    public function subImg($id){
        $artwork = Artwork::with('children','tags')->findorFail($id);
        return view('mypage.art.sub-image', compact('artwork'));
    }
    public function storeSubImg(request $request){
        // バリデーション
        $request->validate([
            'parent_id' => 'required|exists:artworks,id', // 親作品のIDは必須
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 各サブ画像のバリデーション
            'title' => 'required|array',
            'title.*' => 'string|max:255',
            'description' => 'nullable|array',
            'description.*' => 'string|nullable',
        ]);
        // 親作品を取得
        $parentArtwork = Artwork::findOrFail($request->input('parent_id'));
        // サブ画像の登録処理
        foreach ($request->file('image') as $index => $file) {
            // 画像を保存
            $filePath = $this->storeImage($file); // 画像保存メソッドを呼び出し

            // サブ画像の作成
            $subArtwork = new Artwork([
                'parent_id' => $parentArtwork->id, // 親作品のIDを設定
                'artist_id' => $parentArtwork->artist_id, // アーティストIDを親作品から取得
                'title' => $request->input("title.$index"), // サブ画像のタイトルを取得
                'description' => $request->input("description.$index"), // サブ画像の説明を取得
                'image_path' => $filePath, // 保存した画像のパスを設定
            ]);

            $subArtwork->save(); // サブ画像を保存
        }
        return redirect()->route('mypage.art.index')->with('success', 'サブ画像が登録されました。');
    }
    // 画像をストレージに保存するメソッド
    private function storeImage($image)
    {
        $fileName = Str::random(10) . '_' . $image->getClientOriginalName();
        return $image->storeAs('artworks', $fileName, 'public');
    }
    // 登録作品編集フォーム表示
    public function edit($id){
        $artwork = Artwork::with(['children', 'tags'])->findOrFail($id);
        return view('mypage.art.edit', compact('artwork'));
    }

}

