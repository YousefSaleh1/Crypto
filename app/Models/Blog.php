<?php

namespace App\Models;

use App\Models\Comment;
use App\Http\Traits\LikeableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, SoftDeletes,LikeableTrait;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_blogs');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
