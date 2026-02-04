<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['India', '91'],
            ['United States', '1'],
            ['United Kingdom', '44'],
            ['Canada', '1'],
            ['Australia', '61'],
            ['Germany', '49'],
            ['France', '33'],
            ['Italy', '39'],
            ['Spain', '34'],
            ['Japan', '81'],
            ['China', '86'],
            ['Brazil', '55'],
            ['Russia', '7'],
            ['South Africa', '27'],
            ['New Zealand', '64'],
            ['Singapore', '65'],
            ['United Arab Emirates', '971'],
            ['Saudi Arabia', '966'],
            ['Pakistan', '92'],
            ['Bangladesh', '880'],
            ['Nepal', '977'],
            ['Sri Lanka', '94'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['slug' => Str::slug($country[0])],
                [
                    'name' => $country[0],
                    'country_code' => $country[1],
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
