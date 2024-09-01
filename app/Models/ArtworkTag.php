<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtworkTag extends Model
{
    use HasFactory;

    protected $table = 'artwork_tags'; // テーブル名を指定

    protected $fillable = [
        'artwork_id',
        'tag_id',
    ];

    // Artworkとリレーションを定義
    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id');
    }

    // Tagとリレーションを定義
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}

