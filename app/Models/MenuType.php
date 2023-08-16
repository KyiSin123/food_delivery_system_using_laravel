<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function shops() {
        return $this->belongsToMany(Shop::class, 'menu_type_shops');
    }

    public function scopeSort($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeFilter($query, $search)
    {
        return $query->when($search ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
