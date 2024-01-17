<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nft extends Model
{
    use HasFactory;
    protected $fillable = [
        'id' ,
        'user-id' ,
        'file',
        'price',
        'title',
        'description',
        'likes',
        'category-id',
        'currency-id'
    ];
    public function Nft()
    {
        return $this->belongsTo(NftCategory::class);
}
  
}
