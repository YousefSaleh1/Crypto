<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetpasswordController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function sendemail(Request  $request){
        $validated = $request->validate([
            'email' =>'required|email'
        ]);

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

    public function reset(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
            return $this->repetitiveResponse('','Password reset successfully', 200);
        }

        return response([
            'message'=> __($status)
        ], 500);
        

    }
}
