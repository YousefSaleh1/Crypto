<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name ',
        'last_name ',
        'user_name ',
        'display_name ',
        'phone_number ',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
