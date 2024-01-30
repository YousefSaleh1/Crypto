<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    use ApiResponseTrait;

    public function updatePassword(UpdatePasswordRequest $request )
    {
        $user=$request->user();
        if (!Hash::check($request->current_password, $user->password)) {

           return $this->repetitiveResponse( '','Current password is incorrect',422 );

        }
         $user->update([
            'password' => bcrypt($request->new_password)

        ]);

        return $this->repetitiveResponse(  '' ,'Password updated successfully',200 );
    }

}
