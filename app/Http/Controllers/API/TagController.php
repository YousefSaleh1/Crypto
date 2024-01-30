<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Tag;

class TagController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return $this->customeRespone(TagResource::collection($tags), 'Done!', 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $Validation = $request->validated();
        $tag = Tag::create([
            'name' => $request->name
        ]);
        return $this->customeRespone(new TagResource($tag), "Tag Created Successfuly", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        if($tag){
            return $this->customeRespone(new TagResource($tag), "Done!", 200);
        }
        return $this->customeRespone(null, "not found", 404);
    }


}
