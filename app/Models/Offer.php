<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // 案件タイトル
        'offer_type', // 案件タイプ (INT)
        'biz_type', // 報酬タイプ
        'duration', // 案件期間 (Xヶ月 or X月○日～△月□日)
        'budget', // 案件予算
        'application_deadline', // 募集締め切り
        'reward', // 報酬
        'description', // 案件の説明
        'status', // 案件の状態 (0: offered, 1: accepted, 2: declined, 3: completed)
        'recruit_number', // 募集するアーティストの最大人数
        'offered_at', // 案件がオファーされた日
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 案件に関連するアーティスト
     */
    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'offer_artists');
    }

    /**
     * 案件に関連するタグ
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'offer_tags');
    }
}

