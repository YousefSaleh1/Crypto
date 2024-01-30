<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'id',
        'name'
    ];

    public function Nft()
    {
        return $this->belongsTo(Nft::class);
}

}
