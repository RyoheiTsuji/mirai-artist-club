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
        // フォームからの入力データを検証
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'material' => 'required|string|max:255',
            'dimension_type' => 'required|string|in:2D,3D,other', // 2D, 3D, その他を検証
            'size_w' => 'nullable|integer', // サイズは条件付きで検証
            'size_h' => 'nullable|integer',
            'size_d' => 'nullable|integer', // 3Dの場合
            'size_o' => 'nullable|string|max:255', // その他の場合
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'sale_type' => 'required|array',
            'sale_type.*' => 'in:1,2,3,4,5', // 販売状況の検証
            'reason' => 'nullable|string|max:255', // その他の理由の入力
        ]);

        // 画像ファイルの保存処理
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = Str::random(10) . '_' . $image->getClientOriginalName();
            $filePath = $image->storeAs('artworks', $fileName, 'public');
        }

        // 'sale_type' チェックボックスで選ばれた販売状況を配列として保存
        $sale = json_encode($request->input('sale_type'));

        // サイズ情報を初期化
        $size_w = null;
        $size_h = null;
        $size_d = null;
        $size_o = null;

        // 2D, 3D, その他に応じたサイズ入力処理
        if ($request->input('dimension_type') === '2D') {
            $size_w = $request->input('size_w');
            $size_h = $request->input('size_h');
        } elseif ($request->input('dimension_type') === '3D') {
            $size_w = $request->input('size_w');
            $size_h = $request->input('size_h');
            $size_d = $request->input('size_d');
        } elseif ($request->input('dimension_type') === 'other') {
            $size_o = $request->input('size_o');
        }

        // 作品データの基本情報を登録
        $data = [
            'artist_id' => Auth::guard('artist')->id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'material' => $request->input('material'),
            'image_path' => $filePath,
            'sale' => $sale, // 販売状況をJSON形式で保存
            'reason' => $request->input('reason'), // "その他" が選択された場合の理由
        ];
        // 2D, 3D, その他に応じたサイズをdata配列に追加
        if ($request->input('dimension_type') === '2D') {
            $data['size_w'] = $request->input('size_w');
            $data['size_h'] = $request->input('size_h');
        } elseif ($request->input('dimension_type') === '3D') {
            $data['size_w'] = $request->input('size_w');
            $data['size_h'] = $request->input('size_h');
            $data['size_d'] = $request->input('size_d');
        } elseif ($request->input('dimension_type') === 'other') {
            $data['size_o'] = $request->input('size_o');
        }
        // 作品の登録処理
        $artwork = new Artwork($data);
        $artwork->save();

        // タグの保存処理
        $artwork->tags()->sync($request->input('tags'));

        // 管理者向けの通知の作成
        Notification::create([
            'artist_id' => 0, // 管理者向けの通知なので0
            'type' => 'artwork_registered', // 通知の種類
            'data' => json_encode([
                'artwork_id' => $artwork->id,
                'artist_id' => $artwork->artist_id,
                'message' => '新しい作品が登録されました。',
            ]),
            'is_read' => false,
        ]);

        // サブ画像の登録へリダイレクトするか完了するかを選択
        if ($request->input('action') === 'sub_image') {
            return redirect()->route('mypage.art.sub_image', $artwork->id)
                ->with('success', '作品が登録されました。サブ画像の登録へ進みます。');
        }

        return redirect()->route('mypage.art.index')
            ->with('success', '作品が登録されました。');
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

