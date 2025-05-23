<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{

    use HasFactory; 
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function product() {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
}
