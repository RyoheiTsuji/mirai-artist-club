<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * 大量割り当て可能な属性
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'tag_order'];

    /**
     * タグに関連するアーティストを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artist_tags', 'tag_id', 'artist_id');
    }
}
