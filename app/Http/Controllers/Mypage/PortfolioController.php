<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\Artist;

class PortfolioController extends Controller
{
    public function upload(Request $request)
    {

        // バリデーション
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10000', // PDFファイルのみ、最大サイズ10MB
        ]);
        // ログ出力 - フォームデータのバリデーション成功
        Log::info('ポートフォリオアップロード: バリデーション成功');

        $artist = auth()->user();

        // 既存のポートフォリオファイルがある場合は削除
        if ($artist->portfolio_pdf && Storage::exists($artist->portfolio_pdf)) {
            Log::info('ポートフォリオアップロード: 既存のポートフォリオを削除', ['path' => $artist->portfolio_pdf]);
            Storage::delete($artist->portfolio_pdf);
        }

        // 新しいポートフォリオを保存
        $path = $request->file('pdf')->store('public/portfolios');
        Log::info('ポートフォリオアップロード: 新しいポートフォリオが保存されました', ['path' => $path]);

        // データベースに保存
        $artist->portfolio_pdf = $path;
        $artist->save();
        Log::info('ポートフォリオアップロード: ポートフォリオ情報がデータベースに保存されました', ['artist_id' => $artist->id]);

        // 成功メッセージと共にリダイレクト
        return redirect()->back()->with('success', 'ポートフォリオがアップロードされました。');
    }
}
