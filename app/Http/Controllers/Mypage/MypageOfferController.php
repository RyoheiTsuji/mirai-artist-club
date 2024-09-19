<?php

namespace App\Http\Controllers\Mypage;

use App\Models\Offer;
use App\Models\Message;
use App\Models\Notification;


class MypageOfferController
{
    public function index(){
        // ログイン中の作家のIDを取得
        $artistId = auth()->user()->id; // 作家がログインしている前提
        // 作家に関連するオファーを取得
        $offers = Offer::whereHas('artists', function ($query) use ($artistId) {
            $query->where('artist_id', $artistId)
                ->where('applyed', 0);
        })->get();
        $applied = Offer::whereHas('artists', function ($query) use ($artistId) {
            $query->where('artist_id', $artistId)
                ->where('applyed', 1);
        })->get();

        // オファー一覧をビューに渡す
        return view('mypage.offer.index', compact('offers', 'applied'));
    }
    public function showOffer($id){
        // IDに基づいてオファーを取得
        $offer = Offer::with(['artists', 'tags']) // 必要に応じてリレーションをロード
        ->findOrFail($id); // 該当のオファーが見つからなければ404エラーを返す
        // メッセージを取得 (sender_id が現在のユーザーIDと一致するもの)
        $userId = auth()->user()->id;
        $messages = Message::with(['parentMessage', 'senders']) // 必要なリレーションをロード
        ->where('sender_id', $userId)
            ->get();
        // 詳細ページにオファー情報を渡して表示
        return view('mypage.offer.detail', compact('offer', 'messages'));
    }

    public function applyOffer($id){
        return view('mypage.offer.index');
    }

    public function question(){
        return view('mypage.offer.index');
    }
}
