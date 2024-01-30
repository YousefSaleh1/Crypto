<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserinfo;
use App\Http\Resources\UserinfoResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserinfoController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_info = UserInfo::all();

        return $this->repetitiveResponse(UserinfoResource::collection($user_info),' successfully  fetching data', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserinfo $request){
        $validatedData = $request->validated();

        $user_id = Auth::user()->id;
        $user_info = UserInfo::create([
            'user_id'      => $user_id,
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'user_name'    => $request->user_name,
            'display_name' => $request->display_name,
            'phone_number' => $request->phone_number,

        ]);

        if($user_info){
            return $this->repetitiveResponse($user_info,'Successfully Created',201);
        }
        return $this->repetitiveResponse(null,'Build Failed',400);


}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_info = UserInfo::find($id);

        if (!$user_info) {
            return $this->repetitiveResponse(null,'Not Found', 404);
        }

        return $this->repetitiveResponse(new UserinfoResource($user_info),'Found', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserinfo $request, string $id)
    {
        $user_info = UserInfo::find($id);

        if (!$user_info) {
            return $this->repetitiveResponse(null,'Not Found', 404);
        }

        $validator_data = $request->validated();


        $user_info->update([

            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name ,
            'user_name'    => $request->user_name,
            'display_name' => $request->display_name ,
            'phone_number' => $request->phone_number ,

        ]);

        return $this->repetitiveResponse(new UserinfoResource($user_info),'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_info = UserInfo::find($id);

        if (!$user_info) {
            return $this->repetitiveResponse(null,'Not Found', 404);
        }

        $user_info->delete();

        return $this->repetitiveResponse('' ,"UserInfo Deleted", 200);
    }
}
