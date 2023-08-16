<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\Image;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'price',
        'status',
    ];

    public function image() {

        return $this->morphOne(Image::class, 'imageable');
    }

    public function shop() {

        return $this->belongsTo(Shop::class);
    }

    public function orders() {
        
        return $this->belongsToMany(Order::class, 'order_menus');
    }
}
