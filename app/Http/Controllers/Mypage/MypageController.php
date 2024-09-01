<?php

namespace App\Http\Controllers\Mypage;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index()
    {
        $artist = Auth::user()->load('artworks'); // $artist = auth()->user(); でも同様
        return view('mypage.mypage', compact('artist'));
    }
}
