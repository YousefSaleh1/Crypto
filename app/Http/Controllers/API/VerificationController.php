<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVerification;
use App\Http\Resources\VerificationResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    use ApiResponseTrait, UploadPhotoTrait ;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_verification = Verification::all();

        return $this->repetitiveResponse(VerificationResource::collection($user_verification),'Data retrieved successfully', 200);
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
    public function store(StoreVerification $request)
    {
        $validatedData = $request->validated();

        $user_id = Auth::user()->id;

        if (!empty($request->fontside_cardphoto)) {
            $path_fontside_cardphoto = $this->UploadPhoto($request, 'fontsideCards', 'fontside_cardphoto');
        } else {
            $path_fontside_cardphoto = null;
        }
        if (!empty($request->backside_cardphoto)) {
            $path_backside_cardphoto = $this->UploadPhoto($request, 'backsideCards', 'backside_cardphoto');
        } else {
            $path_backside_cardphoto = null;
        }
        if (!empty($request->selfie_photo)) {
            $path_selfie_photo = $this->UploadPhoto($request, 'selfiephotos', 'selfie_photo');
        } else {
            $path_selfie_photo = null;
        }

        $id_number = str_pad(mt_rand(1, 999999999), 10, '0', STR_PAD_LEFT);


        $user_verification = Verification::create([
            'user_id'              =>$user_id,
            'id_number'            =>$id_number,
            'full_name_card'       =>$request->full_name_card,
            'display_name'         =>$request->display_name,
            'user_name'            =>$request->user_name,
            'fontside_cardphoto'   =>$path_fontside_cardphoto,
            'backside_cardphoto'   =>$path_backside_cardphoto,
            'selfie_photo'         =>$path_selfie_photo,
        ]);

        if( $user_verification){
            return $this->repetitiveResponse(new VerificationResource($user_verification),'Successfully Created',201);
        }
        return $this->repetitiveResponse(null,'Build Failed',400);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_verification = Verification::find($id);

        if (!$user_verification) {
            return $this->repetitiveResponse(null,'Not Found', 404);
        }

        return $this->repetitiveResponse(new VerificationResource($user_verification),'Found', 200);

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
    public function update(StoreVerification $request, string $id)
    {
        $user_verification =Verification::find($id);

        if (!$user_verification) {
            return $this->repetitiveResponse(null,'Not Found', 404);
        }

        $validator_data = $request->validated();

        if (!empty($request->fontside_cardphoto)) {
            $path_fontside_cardphoto = $this->UploadPhoto($request, 'fontsideCards', 'fontside_cardphoto');
        } else {
            $path_fontside_cardphoto = $user_verification->fontside_cardphoto;
        }
        if (!empty($request->backside_cardphoto)) {
            $path_backside_cardphoto = $this->UploadPhoto($request, 'backsideCards', 'backside_cardphoto');
        } else {
            $path_backside_cardphoto = $user_verification->backside_cardphoto;
        }
        if (!empty($request->selfie_photo)) {
            $path_selfie_photo = $this->UploadPhoto($request, 'selfiephotos', 'selfie_photo');
        } else {
            $path_selfie_photo =$user_verification->selfie_photo;
        }


        $user_verification->update([
            'full_name_card'       =>$request->full_name_card,
            'display_name'         =>$request->display_name,
            'fontside_cardphoto'   =>$path_fontside_cardphoto,
            'backside_cardphoto'   =>$path_backside_cardphoto,
            'selfie_photo'         =>$path_selfie_photo,
        ]);

        return $this->repetitiveResponse(new VerificationResource ($user_verification),'Successfully Updated', 200);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_verification= Verification::find($id);

        if (!$user_verification) {
            return $this->repetitiveResponse(null,'Not Found', 404);
        }

        $user_verification->delete();

        return $this->repetitiveResponse('' ,"UserVerification Deleted", 200);

    }
}
