<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\MenuType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_name',
        'description',
        'price',
        'status',
        'offer',
        'other_variety',
        'favourite',
    ];

    public function user() {
        
        return $this->belongsTo(User::class);
    }

    public function images() {

        return $this->hasMany(Image::class);
    }

    
}
