<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_id = $this->user_id;
        $user = User::where('id',$user_id)->first();
        $blog_id = $this->blog->id;
        return [
            'id'            =>$this->id,
            'user_id'       =>$user_id,
            'blog_id'       =>$blog_id,
            'body'          => $this->body,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'replies'       => ReplyResource::collection($this->replies),
            'likes_count'   => $this->likesCount('like'),
            'dislikes_count'   => $this->likesCount('dislike'),

        ];
    }
}
