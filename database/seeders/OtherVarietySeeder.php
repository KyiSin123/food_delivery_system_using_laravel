<?php

namespace Database\Seeders;

use App\Models\OtherVariety;
use Illuminate\Database\Seeder;

class OtherVarietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Casual'],
            ['name' => 'Halal'],
        ];

        OtherVariety::insert($data);
    }
}
