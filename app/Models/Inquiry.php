<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
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
        return $this->morphTo();  // user_typeに基づいて適切なモデルを関連付け
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
