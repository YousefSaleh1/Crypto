<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_id = $this->user_id;
        $comment_id = $this->comment_id;
        return [
            'id'            =>$this->id,
            'user_id'       =>$user_id,
            'body'          => $this->body,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'comment_id'    =>$comment_id,
        ];
    }
}
