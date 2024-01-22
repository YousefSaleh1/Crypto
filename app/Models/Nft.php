<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nft extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id' ,
        'user-id' ,
        'file',
        'price',
        'title',
        'description',
        'category-id',
        
    ];

    public function user(){
        return $this->belongsTo(user::class,'user-id');
    }
    public function NftCategory()
    {
        return $this->hasMany(Nft::class);
}
  
}
