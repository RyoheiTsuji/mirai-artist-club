<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTag extends Model
{
    use HasFactory;

    protected $table = 'offer_tags'; // テーブル名を指定

    protected $fillable = [
        'offer_id', // オファーID
        'tag_id', // タグID
    ];

    // Offerとのリレーション (多対多)
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    // Tagとのリレーション (多対多)
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
