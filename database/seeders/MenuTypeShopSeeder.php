<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\MenuType;
use Illuminate\Database\Seeder;

class MenuTypeShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuTypes = MenuType::all();
        $shops = Shop::all();

        $shops->each(function ($shop) use ($menuTypes) {
            $shop->menu_types()->attach(
                $menuTypes->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
