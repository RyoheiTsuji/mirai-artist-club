<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
// タグ登録フォームを表示
    public function create()
    {
        $tags = Tag::orderBy('tag_order')->get();
        return view('admin.tag', compact('tags'));
    }

// タグをデータベースに保存
    public function store(Request $request)
    {

        try {
            // バリデーション
            $validatedData = $request->validate([
                'name' => 'required|string|max:50|unique:tags,name',
                'description' => 'nullable|string',
                'tag_order' => 'nullable|integer',
            ]);
            // 現在の最大のtag_orderを取得し、1を加える
            $maxOrder = Tag::max('tag_order');
            $nextOrder = $maxOrder ? $maxOrder + 1 : 1;

            // 新しいタグを作成
            Tag::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? '',
                'tag_order' => $nextOrder,
            ]);

            // タグ登録成功後のリダイレクト
            return redirect()->route('tags.create')->with('success', 'タグが正常に作成されました。');

        } catch (\Exception $e) {
            // タグ作成時のエラーをログに記録
            return back()->withErrors(['error' => 'タグの作成に失敗しました: ' . $e->getMessage()]);
        }
    }

// タグ削除処理
    public function delete(Request $request)
    {
        try {
            $request->validate([
                'tag_ids' => 'required|array',
                'tag_ids.*' => 'exists:tags,id',
            ]);
            Tag::whereIn('id', $request->input('tag_ids'))->delete();
            return redirect()->route('tags.create')->with('success', 'タグが正常に削除されました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'タグの削除に失敗しました: ' . $e->getMessage()]);
        }
    }

// タグの順序を更新
    public function updateOrder(Request $request)
    {
        try {
            // バリデーション
            $request->validate([
                'orders' => 'required|array',
                'orders.*' => 'integer', // 値が整数であることを確認
            ]);
            // 順序がユニークであるか確認するための配列
            $uniqueOrders = [];
            foreach ($request->input('orders') as $id => $order) {
                if (in_array($order, $uniqueOrders)) {
                    // エラーメッセージをセットし、リダイレクトして処理を中止
                    return redirect()->back()->withErrors(['error' => 'タグの順序に重複があります: ' . $order]);
                }
                $uniqueOrders[] = $order;
            }
            // 重複がない場合にのみ順序を更新
            foreach ($request->input('orders') as $id => $order) {
                $tag = Tag::find($id);
                if ($tag) {
                    // 順序を更新
                    $tag->tag_order = $order;
                    $tag->save();
                } else {
                    Log::warning('タグが見つかりませんでした', ['id' => $id]);
                }
            }
            // 成功メッセージをセットしてリダイレクト
            return redirect()->route('tags.create')->with('success', 'タグの順序が更新されました。');
        } catch (\Exception $e) {
            // エラーログを記録
            Log::error('Failed to update tag order.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // エラーメッセージを表示してリダイレクト
            return redirect()->back()->withErrors(['error' => 'タグの順序の更新に失敗しました。']);
        }
    }



}
