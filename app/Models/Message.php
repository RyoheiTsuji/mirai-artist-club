<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'sender_id',
        'title',
        'content',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * メッセージの親メッセージを取得（リプライの場合）
     */
    public function parentMessage()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    /**
     * メッセージの送信者を取得
     */
    public function senders()
    {
        return $this->belongsToMany(User::class, 'message_senders', 'message_id', 'sender_id')
            ->withPivot('sender_type'); // sender_typeを中間テーブルから取得
    }
}
