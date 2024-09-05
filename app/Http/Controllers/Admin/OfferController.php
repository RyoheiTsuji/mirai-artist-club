<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
use App\Models\Offer;
use App\Models\OfferArtist;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;


class OfferController extends Controller
{
    public function index()
    {
        // 最近登録された5件の案件を取得
        $offers = Offer::orderBy('created_at', 'desc')->take(5)->get();

        // ビューにデータを渡して表示
        return view('admin.offer', compact('offers'));
    }

    public function create()
    {
        // タグ（作風カテゴリ）を取得する
        $tags = Tag::all();
        $offerTypes = config('admin_setting.OFFER_TYPES');

        return view('admin.offer_create', compact('tags', 'offerTypes'));
    }


    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'offer_type' => 'required|integer',
            'title' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'recruit_number' => 'required|integer|min:1',
            'budget' => 'required|integer',
            'application_deadline' => 'required|date',
            'reward' => 'required|string|max:255',
            'biz_type' => 'required|string|max:255',
            'collab_with' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'selected_artists' => 'array',
            'selected_artists.*' => 'integer|exists:artists,id'
        ]);
        try {
            // トランザクションで保存
            DB::transaction(function () use ($validatedData) {
                // Offer を作成
                $offer = Offer::create([
                    'offer_type' => $validatedData['offer_type'],
                    'title' => $validatedData['title'],
                    'duration' => $validatedData['duration'],
                    'application_deadline' => $validatedData['application_deadline'],
                    'recruit_number' => $validatedData['recruit_number'],
                    'budget' => $validatedData['budget'],
                    'reward' => $validatedData['reward'],
                    'biz_type' => $validatedData['biz_type'],
                    'collab_with' => $validatedData['collab_with'],
                    'description' => $validatedData['description'],
                    'status' => 1,
                ]);

                // OfferArtist を作成して、作家を紐づける
                foreach ($validatedData['selected_artists'] as $artistId) {
                    OfferArtist::create([
                        'offer_id' => $offer->id,
                        'artist_id' => $artistId
                    ]);
                }
            });

            return redirect()->route('admin.offer')->with('success', '案件が作成されました');
        } catch (\Exception $e) {
            // エラーメッセージをログに出力
            Log::error('Error during offer creation: ' . $e->getMessage());
            return redirect()->back()->with('error', '案件の作成中にエラーが発生しました。');
        }
    }

    public function edit($id)
    {
        // 該当の案件を取得
        $offers = Offer::with('artists')->findOrFail($id);
        $tags = Tag::all();

        // 必要なデータをbladeファイルに渡して、編集画面を表示
        return view('admin.offer_create', compact('offers', 'tags'));
    }

    public function update(Request $request, $id)
    {

        // バリデーション
        $validatedData = $request->validate([
            'offer_type' => 'required|integer',
            'title' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'recruit_number' => 'required|integer|min:1',
            'budget' => 'required|integer',
            'application_deadline' => 'required|date',
            'reward' => 'required|string|max:255',
            'biz_type' => 'required|string|max:255',
            'collab_with' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'selected_artists' => 'array',
            'selected_artists.*' => 'integer|exists:artists,id'
        ]);

        // トランザクションで保存
        DB::transaction(function () use ($validatedData, $id) {
            // 該当のOfferを取得
            $offer = Offer::findOrFail($id);

            // Offerを更新
            $offer->update([
                'offer_type' => $validatedData['offer_type'],
                'title' => $validatedData['title'],
                'duration' => $validatedData['duration'],
                'application_deadline' => $validatedData['application_deadline'],
                'recruit_number' => $validatedData['recruit_number'],
                'budget' => $validatedData['budget'],
                'reward' => $validatedData['reward'],
                'biz_type' => $validatedData['biz_type'],
                'collab_with' => $validatedData['collab_with'],
                'description' => $validatedData['description'],
            ]);

            // OfferArtistを更新（まず既存の関連を削除してから新規追加）
            OfferArtist::where('offer_id', $id)->delete();
            foreach ($validatedData['selected_artists'] as $artistId) {
                OfferArtist::create([
                    'offer_id' => $offer->id,
                    'artist_id' => $artistId
                ]);
            }
        });
        return redirect()->route('admin.offer')->with('success', '案件が更新されました');
    }

    public function delete(Request $request)
    {
        try {
            // バリデーション（削除する案件のIDが必要）
            $validatedData = $request->validate([
                'offer_id' => 'required|integer|exists:offers,id',
            ]);

            // トランザクションで削除処理を行う
            DB::transaction(function () use ($validatedData) {
                // OfferArtistの関連データを削除
                OfferArtist::where('offer_id', $validatedData['offer_id'])->delete();

                // 該当するOfferを削除
                $offer = Offer::findOrFail($validatedData['offer_id']);
                $offer->delete();
            });

            // 削除成功後、リダイレクトとメッセージ
            return redirect()->route('admin.offer')->with('success', '案件が削除されました');

        } catch (\Exception $e) {
            // エラー時の処理
            Log::error('Error during offer deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', '案件の削除中にエラーが発生しました。');
        }
    }

    public function searchArtists(Request $request)
    {

        // バリデーション
        $validatedData = $request->validate([
            'level' => 'nullable|integer',
            'tag' => 'nullable|integer|exists:tags,id',
            'keyword' => 'nullable|string|max:255',
        ]);

        // クエリの準備
        $query = Artist::query();

        // 作家レベルでのフィルタリング
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // タグ（作風）でのフィルタリング
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // フリーワードでのフィルタリング（カラムを絞る）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')  // 作家名
                ->orWhere('description', 'like', '%' . $keyword . '%');  // 作家の説明等
            });
        }

        // 結果を取得
        $artists = $query->with('tags')->get();

        // 作家情報とそのタグ（作風）をレスポンスに含める
        $response = $artists->map(function($artist) {
            return [
                'id' => $artist->id,
                'name' => $artist->name,
                'level' => $artist->level,
                'tag_names' => $artist->tags->pluck('name')->toArray() ?: ['タグがありません']
            ];
        });

        return response()->json(['artists' => $response]);
    }




}
