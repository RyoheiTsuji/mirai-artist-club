<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        // 検索条件を受け取る
        $keyword = $request->input('keyword');
        $tagId = $request->input('tag_id');
        $order = $request->input('order', 'desc'); // デフォルトは降順

        // アーティストクエリの構築
        $query = Artist::with('tags');

        // キーワード検索
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('pr_statement', 'like', "%$keyword%");
            });
        }

        // タグ絞り込み
        if (!empty($tagId)) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        // 並び替え
        $query->orderBy('created_at', $order);

        // 結果を取得
        $artists = $query->get()->map(function ($artist) {
            // 年齢の計算
            $age = Carbon::parse($artist->birthday)->age;

            // タグの取得（カンマ区切りではなく、配列として取得）
            $tags = $artist->tags->pluck('name')->toArray();
            return [
                'id' => $artist->id,
                'photo_url' => $artist->photo_url,
                'name' => $artist->name,
                'age' => $age,
                'tags' => $tags,  // 配列として返す
                'pr_statement' => $artist->pr_statement,
            ];
        });

        // タグ一覧の取得（絞り込み用）
        $tags = Tag::orderBy('tag_order')->get();

        // 過去12ヶ月間の会員数（アーティスト数）を取得
        $monthlyUsers = Artist::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create($item->year, $item->month)->format('Y-m') => $item->count];
            })
            ->toArray();

        // 過去12ヶ月のキー（例: 2023-08）を生成
        $months = collect(range(0, 11))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('Y-m');
        })->reverse();

        // グラフ用のデータ
        $chartData = $months->map(function ($month) use ($monthlyUsers) {
            return $monthlyUsers[$month] ?? 0;

            // メイン画像を取得
            $artwork = Artwork::findOrFail($id);

            // 関連するサブ画像を取得
            $subArtworks = $artwork->children;
        });

        return view('admin.artist', compact('artists', 'tags', 'chartData', 'months', 'keyword', 'tagId', 'order'));
    }
    public function detail($id)
    {
        // アーティストとそのタグ、および関連するアートワークを一緒に取得
        $artist = Artist::with(['tags', 'artworks'])->findOrFail($id);
        $age = Carbon::parse($artist->birthday)->age;

        return view('admin.artist_detail', [
            'artist' => $artist,
            'age' => $age,
        ]);
    }
}
