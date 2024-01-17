<?php

namespace App\Http\Traits;

use App\Http\Resources\CategoriesResource;

trait ApiResponseTrait
{
    public function apiResponse($data,$token,$message,$status){

        $array = [
            'data' =>$data,
            'meassge' =>$message,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response()->json($array,$status);
    }
}
