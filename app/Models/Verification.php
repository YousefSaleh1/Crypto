<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'id_number',
        'full_name_card',
        'display_name',
        'user_name',
        'fontside_cardphoto',
        'backside_cardphoto',
        'selfie_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
