<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    // データをJSON形式で保存するためのキャスト
    protected $casts = [
        'data' => 'array',
    ];

    // ユーザー（管理者）とのリレーション
    public function user()
    {
        return $this->belongsTo(Artist::class);
    }
}


