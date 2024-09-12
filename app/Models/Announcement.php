<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_type',
        'content_type',
        'event_start_date',
        'event_end_date',
        'publish_start_date',
        'publish_end_date',
        'calendar_flag',
        'photo_url',
        'title',
        'content',
    ];

    // SoftDeletesで使用するカラム
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 管理者、作家、一般ユーザーとのリレーション（多態リレーション）
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * 管理者を取得するリレーション
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id')->where('user_type', 0);
    }

    /**
     * 作家を取得するリレーション
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'user_id')->where('user_type', 1);
    }

    /**
     * 一般ユーザーを取得するリレーション
     */
    public function userAccount()
    {
        return $this->belongsTo(User::class, 'user_id')->where('user_type', 2);
    }
}
