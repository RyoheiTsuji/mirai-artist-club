<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 使用するテーブル名
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * 大量割り当て可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * シリアライズ時に隠す属性
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 管理者が送信したメッセージを取得
     */
    public function sentMessages()
    {
        return $this->belongsToMany(Message::class, 'message_senders', 'sender_id', 'message_id')
            ->wherePivot('sender_type', 'admin');
    }

    public function inquiries()
    {
        return $this->morphMany(Inquiry::class, 'user');
    }

    /**
     * 管理者が作成したお知らせのリレーション
     */
    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'user');
    }

}
