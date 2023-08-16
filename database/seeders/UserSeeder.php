<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 11; $i++) {
            User::create([
                'name' => 'user'.$i,
                'email' => 'user'.$i.'@gmail.com',
                'password' => Hash::make('123456789'),
                'status' => 'buyer',
                'created_at' => now(),
            ]);
        }        
        User::factory()
            ->count(10)
            ->create();

        $users = User::latest('id')->take(10)->get();
        foreach($users as $user) {
            Shop::create([
                'user_id' => $user->id,
                'name' => fake()->name(),
                'ph_number' => '09'.Str::random(9),
                'shop_address' => fake()->text(),
                'is_published' => true,
            ]);
        }

        $shops = Shop::latest('id')->take(10)->get();
        foreach($shops as $shop) {
            Image::create([
                'imageable_type' => get_class($shop),
                'imageable_id' => $shop->id,
                'name' => 'kaw_pyant.jpg',
                'path' => 'storage/images/kaw_pyant.jpg',
            ]);
            Image::create([
                'imageable_type' => get_class($shop),
                'imageable_id' => $shop->id,
                'name' => 'banana_kawpyant.jpg',
                'path' => 'storage/images/banana_kawpyant.jpg',
            ]);
            Image::create([
                'imageable_type' => get_class($shop),
                'imageable_id' => $shop->id,
                'name' => 'akyawsone.jpg',
                'path' => 'storage/images/akyawsone.jpg',
            ]);
        }
    }
}
