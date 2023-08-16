<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'total_price',
    ];

    public function menus() {
        return $this->belongsToMany(Menu::class, 'order_menus');
    }

    public function shop() {

        return $this->belongsTo(Shop::class);
    }

    public function scopeFilter($query, $search)
    {
        return $query->when($search ?? false, function ($query, $search) {
            $query->whereHas('shop', function($query1) use ($search) {
                    $query1->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('menus', function($query2) use ($search) {
                    $query2->where('name', 'like', '%' . $search . '%');
                });
        });
    }
}
