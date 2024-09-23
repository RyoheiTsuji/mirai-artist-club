<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class MypageCommentController extends Controller
{
    // コメント管理ページの表示
    public function index()
    {
        $artist_id = Auth::id(); // ログイン中の作家ID
        $comments = Comment::where('artist_id', $artist_id)->get(); // 作家のコメントを取得

        return view('mypage.comment.index', compact('comments'));
    }

    // コメントの新規登録および編集
    public function register(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:500', // コメントのバリデーション (最大500文字と仮定)
        ]);

        $artist_id = Auth::id();

        // 新規コメントまたは既存コメントの更新
        Comment::updateOrCreate(
            ['id' => $request->input('comment_id')], // comment_id が空の場合、新規登録
            [
                'artist_id' => $artist_id,
                'content' => $request->input('comment'),
                'status' => 1 // 新規コメントはデフォルトで公開
            ]
        );

        return redirect()->route('mypage.comment')->with('success', 'コメントが登録されました。');
    }

    // コメントの公開/非公開ステータス変更 (AJAX)
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|integer|exists:comments,id',
            'status' => 'required|boolean', // ステータスは公開(1)か非公開(0)か
        ]);

        $comment = Comment::find($request->input('comment_id'));

        // ログイン中の作家がコメントの所有者であることを確認
        if ($comment->artist_id == Auth::id()) {
            $comment->status = $request->input('status');
            $comment->save();

            return response()->json(['success' => 'ステータスが更新されました。']);
        } else {
            return response()->json(['error' => '操作権限がありません。'], 403);
        }
    }

    // コメントの削除 (AJAX)
    public function delete(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $comment = Comment::find($request->input('comment_id'));

        // ログイン中の作家がコメントの所有者であることを確認
        if ($comment->artist_id == Auth::id()) {
            $comment->delete(); // 論理削除
            return response()->json(['success' => 'コメントが削除されました。']);
        } else {
            return response()->json(['error' => '操作権限がありません。'], 403);
        }
    }
}

