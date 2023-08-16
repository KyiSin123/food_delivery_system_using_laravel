<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\MenuType;
use App\Models\NetRating;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory, Markable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'ph_number',
        'shop_address',
        'is_published',
        'status',
    ];

    protected static $marks = [
        Favorite::class,
    ];

    public function user() {
        
        return $this->belongsTo(User::class);
    }

    public function menu_types() {
        
        return $this->belongsToMany(MenuType::class, 'menu_type_shops');
    }

    public function images() {

        return $this->morphMany(Image::class, 'imageable');
    }

    public function menus() {
        
        return $this->hasMany(Menu::class);
    }

    public function orders() {

        return $this->hasMany(Order::class);
    }

    public function rating() {

        return $this->belongsTo(Rating::class);
    }

    public function net_rating() {

        return $this->hasOne(NetRating::class);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeFilter($query, $search)
    {
        return $query->when($search ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('shop_address', 'like', '%' . $search . '%')
                ->orWhereHas('menu_types', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        });
    }
}
