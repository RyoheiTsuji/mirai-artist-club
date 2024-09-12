<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $portfolio_pdf
 * @property int $level
 */

class Artist extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 使用するテーブル名
     *
     * @var string
     */

    protected $table = 'artists';

    /**
     * 大量割り当て可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'pr_statement',
        'address',
        'birthday',
        'phone_number',
        'photo_url',
        'email_verified_at',
        'created_at',
        'updated_at',
        'token',
        'level',           // 追加された属性
        'portfolio_pdf',   // 追加された属性
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
        'birthday' => 'date',
    ];

    /**
     * パスワードの自動ハッシュ化
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * アーティストが持つタグを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'artist_tags', 'artist_id', 'tag_id');
    }

    /**
     * アーティストが持つ作品を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    /**
     * アーティストが関わるオファーを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'offer_artists', 'artist_id', 'offer_id');
    }

    /**
     * 作家が作成したお知らせのリレーション
     */
    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'user');
    }

}
