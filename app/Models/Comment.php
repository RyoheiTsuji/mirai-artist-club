<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // フィールドに対してのホワイトリスト
    protected $fillable = [
        'artist_id',
        'content',
        'status'
    ];

    // 作家とのリレーション (コメントは1人の作家に属する)
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

}

