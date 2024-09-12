<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSender extends Model
{
    use HasFactory;

    protected $table = 'message_senders';

    protected $fillable = [
        'message_id',
        'sender_id',
        'sender_type',
    ];

    /**
     * メッセージに関連付ける
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * 送信者（アーティストまたは管理者）に関連付ける
     */
    public function sender()
    {
        return $this->morphTo();
    }
}
