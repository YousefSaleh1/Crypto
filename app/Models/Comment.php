<?php

namespace App\Models;

use App\Models\Blog;
use App\Models\like;
use App\Models\Reply;
use App\Http\Traits\LikeableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory,SoftDeletes,LikeableTrait;

    protected $fillable = [
        "body",
        "user_id",
        "blog_id",
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the comments for the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function likes()
    {
        return $this->morphMany(like::class, 'likable');
    }

}
