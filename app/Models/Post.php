<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable  = [
        'body',
    ];

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id); // Collection
    }

    // user테이블과의 연관관계 지정(다:1)
    // 이런 연관관계를 이용해 각 데이터의 연관값을 가져올수 있다.($post->user()->first()과 같이 Eloquent를 사용. 해당 포스트의 유저 데이터를 가져오는것 등)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
