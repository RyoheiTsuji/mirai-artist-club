<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Artist;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ダッシュボードに表示するための各種データを取得
        $data = [
            'artistCount' => Artist::count(),
            'adminCount' => Admin::count(),
            'tagCount' => Tag::count(),
            ];
        return view('admin.dashboard', $data);
    }
}
