<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'likable_id',
        'likable_type',
        'reaction'
    ];

    public function likeable()
    {
        return $this->morphTo();
    }
}
