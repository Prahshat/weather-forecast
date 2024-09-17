<?php

namespace App\Plugins\ForecastPlugin\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Plugins\ForecastPlugin\Models\City;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            'name' => 'Palma',
            'latitude' => '39.5727',
            'longitude' => '2.6569',
        ]);
    }
}
