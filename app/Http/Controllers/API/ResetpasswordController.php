<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetpasswordController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function sendemail(EmailRequest  $request){

        $status = password::sendResetLink(
            $request->only('email')

        );
        if($status == password::RESET_LINK_SENT){
            return[
                'status' =>__($status)
            ];
        }
        throw ValidationException::withMessages([
            'email' => [trans($status)]
        ]);

    }

    public function reset(ResetPasswordRequest $request){

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}

