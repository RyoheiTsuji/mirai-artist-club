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
        // バリデーション（ファイルがアップロードされたか、jpg, png形式か確認）
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg|max:2048',
        ]);

        // ファイルを保存
        $path = $request->file('file')->store('public/img');

        return redirect()->back()->with('success', 'ファイルがアップロードされました。');
    }
}
