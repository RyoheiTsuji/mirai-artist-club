<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Artist;

class PortfolioController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'portfolio' => 'required|mimes:pdf|max:10000', // PDFファイルのみ、最大サイズ10MB
        ]);

        $artist = auth()->user();

        // 既存のポートフォリオファイルがある場合は削除
        if ($artist->portfolio_pdf && Storage::exists($artist->portfolio_pdf)) {
            // ファイルが存在する場合のみ削除を行う
            Storage::delete($artist->portfolio_pdf);
        }

        // 新しいポートフォリオを保存
        $path = $request->file('portfolio')->store('public/portfolios');
        $artist->portfolio_pdf = $path;
        $artist->save();

        return redirect()->back()->with('success', 'ポートフォリオがアップロードされました。');
    }
}
