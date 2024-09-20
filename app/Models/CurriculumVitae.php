<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumVitae extends Model
{
    use HasFactory, SoftDeletes;

    // テーブル名を指定
    protected $table = 'curriculum_vitae';

    // 更新可能なカラムを指定
    protected $fillable = [
        'artist_id',
        'year',
        'month',
        'details',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Artistsテーブルとのリレーション
     * CurriculumVitaeは1人のアーティストに属する
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }
}
