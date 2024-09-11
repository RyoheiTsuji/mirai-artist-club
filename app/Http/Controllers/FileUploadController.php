<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('/admin/file-upload');
    }

    public function upload(Request $request)
    {
        // バリデーション
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // 元のファイル名を取得
        $originalName = $request->file('file')->getClientOriginalName();

        // ファイルを保存（元の名前を使って保存）
        $path = $request->file('file')->storeAs('public/img', $originalName);

        return redirect()->back()->with('success', 'ファイルがアップロードされました。');
    }

}
