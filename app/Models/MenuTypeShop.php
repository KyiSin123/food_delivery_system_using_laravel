<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuTypeShop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'menu_type_id',
    ];
}
