<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'affiliation',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function inquiries()
    {
        return $this->morphMany(Inquiry::class, 'user');
    }

    /**
     * 一般ユーザーが作成したお知らせのリレーション
     * 利用しないかも
     */
    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'user');
    }
}
