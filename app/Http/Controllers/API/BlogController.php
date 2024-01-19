<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    use ApiResponseTrait, UploadPhotoTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return $this->customeRespone(BlogResource::collection($blogs), 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $user_id = Auth::user()->id;
        if (!empty($request->photo)) {

            $path = $this->UploadPhoto($request, 'blogs', 'photo');
        } else {
            $path = null;
        }

        $blog = Blog::create([
            'user_id' => $user_id,
            'title' => $request->title,
            'body' => $request->body,
            'photo' => $path,
        ]);

        if ($request->has('tags')) {
            $blog->tags()->attach($request->input('tags'));
        }
        return $this->customeRespone(new BlogResource($blog), "Blog Created Successfuly", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        if($blog){
            $blog->load('tags');
            return $this->customeRespone(new BlogResource($blog), "Done!", 200);
        }
        return $this->customeRespone(null, "not found", 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        if (!empty($request->photo)) {

            $path = $this->UploadPhoto($request, 'blogs', 'photo');
        } else {
            $path = $blog->photo;
        }

        $blog->update([
            'title' => $request->title,
            'body' => $request->body,
            'photo' => $path,
        ]);

        if ($request->has('tags')) {
            $blog->tags()->attach($request->input('tags'));
        }

        return $this->customeRespone(new BlogResource($blog), "Blog Updated Successfuly", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog) {
            $blog->tags()->detach();
            $blog->delete();
            return $this->customeRespone(null , "Blog deleted successfully" , 200);
        }

        return $this->customeRespone(null, "not found", 404);
    }
}
