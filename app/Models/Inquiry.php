<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',    // 管理者の外部キー
        'artist_id',   // 作家の外部キー
        'user_id',     // 一般ユーザの外部キー
        'submitted_by_user_id',
        'created_by_admin_id',
        'created_by_artist_id',
        'user_type',
        'inq_type',
        'subject',
        'message',
        'status',
        'parent_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by_admin_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'created_by_artist_id');
    }

    public function parentInquiry()
    {
        return $this->belongsTo(Inquiry::class, 'parent_id');
    }

    public function childInquiries()
    {
        return $this->hasMany(Inquiry::class, 'parent_id');
    }
}

