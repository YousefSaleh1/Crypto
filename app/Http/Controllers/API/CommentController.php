<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        if($blog){
            $comments = Comment::where('blog_id',$blog->id)->get();
            return $this->customeRespone(CommentResource::collection($comments), 'Done!', 200);
        }else {
            return $this->customeRespone(null, "Blog Not found", 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request,$blog_id)
    {
        $user_id = Auth::user()->id;
        $Validation = $request->validated();
        $blog = Blog::where('id',$blog_id)->first();
        if($blog) {
            $comment = Comment::create([
                'user_id' => $user_id,
                'blog_id' => $blog->id,
                'body' => $request->body,
            ]);

            return $this->customeRespone(new CommentResource($comment), "Comment Created Successfuly", 200);

        }else{
            return $this->customeRespone(null, "Blog Not found", 404);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        if($comment) {
            return $this->customeRespone(new CommentResource($comment), "Done", 200);
        }else{
            return $this->customeRespone(null, "Comment Not found", 404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {

        if($comment){
            if (Auth::user()->id !== $comment->user_id) {
                return $this->customeRespone(null, 'You can only edit your own comment.', 403);
            } else {
                $Validation = $request->validated();
                $comment->update([
                    'body' => $request->body,
                ]);
                return $this->customeRespone(new CommentResource($comment), "Comment Updated Successfuly", 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if ($comment) {
            $comment->delete();
            return $this->customeRespone(null , "Comment deleted successfully" , 200);
        }

        return $this->customeRespone(null, "not found", 404);
    }

}
