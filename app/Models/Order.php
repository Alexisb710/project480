<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
