<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Tag;
use App\Models\Message;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index()
    {
        // Level 2以上のアーティストを取得
        $artists = Artist::where('level', '>=', 2)->get();
        // tagsテーブルから全タグを取得
        $tags = Tag::all();
        return view('admin.message', compact('artists', 'tags'));
    }

    public function store(Request $request)
    {
        Log::info('登録処理開始');
        // バリデーション
        $validatedData = $request->validate([
            'sender_id' => 'required|integer',
            'sender_type' => 'required|string',
            'recipients' => 'required|array', // 受信者のリストが必須
            'recipients.*' => 'integer|exists:artists,id', // 各受信者はartistsテーブルのIDに存在する必要がある
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);
        Log::info('バリデーション通過');

        // メッセージデータの作成
        $message = Message::create([
            'sender_id' => $validatedData['sender_id'],
            'title' => $validatedData['title'],
            'content' => $validatedData['message'],
            'status' => 0, // デフォルトでステータスを0に設定
        ]);
        Log::info('メッセージテーブル登録完了');

        // メッセージデータが保存されたかを確認し、次のステップへ
        if ($message) {
            // 直前に保存されたレコードのIDを取得
            $messageId = $message->id;

            // message_sendersテーブルにデータを挿入
            DB::table('message_senders')->insert([
                'sender_id' => $validatedData['sender_id'],
                'message_id' => $messageId,
                'sender_type' => $validatedData['sender_type'],
                'recipients' => json_encode($validatedData['recipients']), // 配列をJSON形式で保存
            ]);
            Log::info('中間テーブル登録完了');
        }

        return redirect()->route('admin.message')->with('success', 'メッセージが送信されました');
    }

    public function search(Request $request)
    {
        $tags = Tag::all();
        $query = Artist::query();

        // キーワードでの検索
        if ($request->has('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('bio', 'like', '%' . $request->keyword . '%')
                    ->orWhere('pr_statement', 'like', '%' . $request->keyword . '%');
            });
        }

        // レベルでのフィルタリング
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // タグでのフィルタリング
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // アーティストリストを取得
        $artists = $query->get();
        // デバッグ用にクエリ結果をログに出力
        Log::info('Artists found: ', ['artists' => $artists]);
        // Bladeテンプレートを使ってHTMLを生成
        $html = view('components.search-result', compact('artists', 'tags'))->render();
        // デバッグ用に生成したHTMLをログに出力
        Log::info('Generated HTML: ' . $html);
        // HTMLをAjaxに返す
        return response()->json(['html' => $html]);
    }


}
