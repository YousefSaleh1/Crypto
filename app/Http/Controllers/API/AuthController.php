<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerifyRequest;
use App\Http\Requests\StoreUser;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreUser $request){

        $user = $request->validated();

        $AccountID = str_pad(mt_rand(1, 999999999),8 , '0', STR_PAD_LEFT);

        $user = User::create([
            'email'    => $user['email'],
            'password' => Hash::make($user['password']),
            'uid'      => $AccountID,
        ]);

        // Generate a random verification code
        $code= mt_rand(1000, 9999);

        // Store the verification code in the user's record
        $data['code'] = $code;
        $data['email'] = $user->email;
        $data['title'] = 'Email Verification';

        Mail::send('emails.verify', ['data' =>$data], function($message) use ($data){
            $message->to($data['email'])->subject($data['title']);
        });

        //save the verification code
        $user->verification_code = $data['code'];
        $user->save();

        return response()->json(['message' => 'verification-link-sent']);
    }

    public function verify(EmailVerifyRequest $request){
        $user= User::where ('email', $request->email )->first();
        if($user){
            $user->email_verified_at = now();
            $token = $user->createToken('authToken')->plainTextToken;
            $user->save();
        }
        else{
            return $this->repetitiveResponse(null , 'not found' , 404);

        }
        return $this->apiResponse(new UserResource($user),$token,' verfied Email and registered successfully',200);

    }


    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return $this->apiResponse(new UserResource($user),$token,'successfully login,welcome!',200);

    }

    public function logout(Request $request)
    {
        if ($request->user()) {

        $request->user()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);

    } else {
        return response()->json([
            'error' => 'No active session found'
        ], 422);
    }
}
}


