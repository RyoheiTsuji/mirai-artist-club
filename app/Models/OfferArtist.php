<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferArtist extends Model
{
    use HasFactory;

    protected $table = 'offer_artists'; // テーブル名を指定

    protected $fillable = [
        'offer_id', // オファーID
        'artist_id', // アーティストID
        'applyed', // 応募済み:1 未応募:0
    ];

    // Offerとのリレーション (多対多)
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    // Artistとのリレーション (多対多)
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
