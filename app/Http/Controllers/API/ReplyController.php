<?php

namespace App\Http\Controllers\API;

use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReplyResource;
use App\Http\Traits\ApiResponseTrait;

class ReplyController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Comment $comment)
    {
        if(!$comment){
            return $this->customeRespone(null, "comment Not found", 404);
        }else {
            $replies = Reply::where('comment_id',$comment->id)->get();
            return $this->customeRespone(ReplyResource::collection($replies), 'Done!', 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReplyRequest $request,$comment_id)
    {
        $user_id = Auth::user()->id;
        $Validation = $request->validated();
        $comment = Comment::where('id',$comment_id)->first();
        if($comment) {
            $reply = Reply::create([
                'user_id' => $user_id,
                'comment_id' => $comment->id,
                'body' => $request->body,
            ]);

            return $this->customeRespone(new ReplyResource($reply), "Reply Created Successfuly", 200);

        }else{
            return $this->customeRespone(null, "Comment Not found", 404);
        }

    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReplyRequest $request, Reply $reply)
    {
        if($reply){
            if (Auth::user()->id !== $reply->user_id) {
                return $this->customeRespone(null, 'You can only edit your own reply.', 403);
            } else {
                $Validation = $request->validated();
                $reply->update([
                    'body' => $request->body,
                ]);
                return $this->customeRespone(new ReplyResource($reply), "Reply Updated Successfuly", 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        if ($reply) {
            $reply->delete();
            return $this->customeRespone(null , "Reply deleted successfully" , 200);
        }

        return $this->customeRespone(null, "not found", 404);
    }
}
