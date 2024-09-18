<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'artist_id',
        'title',
        'material',
        'description',
        'image_path',
        'size_w',
        'size_h',
        'size_d',
        'size_o',
        'proved',
    ];

    /**
     * アートワークが属するアーティストを取得
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * アートワークに関連するタグを取得
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'artwork_tags', 'artwork_id', 'tag_id')
            ->withTimestamps();
    }

    /**
     * アートワークに関連するピボットテーブル (artwork_tags) を取得
     */
    public function artworkTags()
    {
        return $this->hasMany(ArtworkTag::class, 'artwork_id');
    }

// 親作品（メイン画像）を取得
    public function parent()
    {
        return $this->belongsTo(Artwork::class, 'parent_id');
    }
// 関連するサブ作品（サブ画像）を取得
    public function children()
    {
        return $this->hasMany(Artwork::class, 'parent_id');
    }
}
