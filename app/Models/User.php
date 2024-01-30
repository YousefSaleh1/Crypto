<?php

namespace App\Models;

use App\Models\Provider;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Verification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    /* The relationships with other Tables */

    public function user_info()
    {
        return $this->hasOne( UserInfo::class);
    }

    public function user_verification()
    {
        return $this->hasOne( Verification::class);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }


    public function sendPasswordResetNotification($token){
        $url = 'http://127.0.0.1:8000/reset-password?token=' . $token;
        $this->notify(new ResetPasswordNotification($url));
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
