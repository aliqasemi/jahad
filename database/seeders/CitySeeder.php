<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\County;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('provinces') as $province) {
            Province::create($province);
        }

        foreach (config('counties') as $county) {
            County::create($county);
        }

        foreach (config('cities') as $city) {
            City::create($city);
        }
    }
}
