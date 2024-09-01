<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistTag extends Model
{
    // 中間テーブルのカラムにアクセスするための設定
    protected $table = 'artist_tags';
    public $timestamps = false;

    // ホワイトリストの指定
    protected $fillable = [
        'artist_id',
        'tag_id',
    ];
}

