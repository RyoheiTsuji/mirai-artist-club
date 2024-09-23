<?php

namespace App\Http\Controllers\Mypage;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MypageInquiryController
{
    public function index(){
        $user_id = Auth::id();
        $inquiries = Inquiry::where('created_by_artist_id', $user_id)
            ->with('childInquiries') // リレーションを使って子データを取得
            ->get();

        return view('mypage.inquiry.index', compact('inquiries', 'user_id'));
    }
    public function register(Request $request)
    {
        // バリデーションルール
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // フォームから送られてきたデータを使って問い合わせを作成
        Inquiry::create([
            'user_id' => Auth::id(), // ログイン中のユーザID
            'user_type' => 1, // ユーザータイプ:作家
            'inq_type' => 2, // 問い合わせタイプ:作家からの問い合わせ
            'subject' => $request->input('subject'), // 件名
            'message' => $request->input('content'), // 問い合わせ内容
            'created_by_artist_id' => Auth::id(), // 作成者としてログイン中のアーティストIDを指定
        ]);

        // 成功した場合は元のページにリダイレクトし、成功メッセージを表示
        return redirect()->route('mypage.inquiry')->with('success', '問い合わせが登録されました。');
    }
    public function reply(Request $request)
    {
        // バリデーション
        $request->validate([
            'inquiry_id' => 'required|integer|exists:inquiries,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 新しい返信を作成
        Inquiry::create([
            'parent_id' => $request->input('inquiry_id'), // 返信元の問い合わせ
            'user_id' => $request->input('artist_id'),
            'user_type' => $request->input('user_type'),
            'inq_type' => $request->input('inq_type'),
            'created_by_artist_id' => $request->input('created_by_artist_id'),
            'subject' => $request->input('subject'), // subject を保存
            'message' => $request->input('message'),
        ]);

        return redirect()->route('mypage.inquiry')->with('success', '問い合わせが登録されました。');
    }


}
