<?php

namespace Database\Seeders;

use App\Models\MenuType;
use Illuminate\Database\Seeder;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Bakery'],
            ['name' => 'Beverages'],
            ['name' => 'Bubble Tea'],
            ['name' => 'Burger'],
            ['name' => 'Burmese'],
            ['name' => 'Cakes'],
            ['name' => 'Chicken'],
            ['name' => 'Chinese'],
            ['name' => 'Curry'],
            ['name' => 'Desserts'],
            ['name' => 'Dim Sum'],
            ['name' => 'Dumpling'],
            ['name' => 'European'],
            ['name' => 'Fish'],
            ['name' => 'Indian'],
            ['name' => 'Japanese'],
            ['name' => 'Korean'],
            ['name' => 'Noodles'],
            ['name' => 'Pasta'],
            ['name' => 'Pizza'],
            ['name' => 'Rice'],
            ['name' => 'Salads'],
            ['name' => 'Sandwich'],
            ['name' => 'Seafood'],
            ['name' => 'Soups'],
            ['name' => 'Steak'],
            ['name' => 'Sushi'],
            ['name' => 'Tea'],
            ['name' => 'Coffee'],
            ['name' => 'vegetarian'],
        ];
        
        MenuType::insert($data);
    }
}
