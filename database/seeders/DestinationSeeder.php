<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Europe',
                'code' => 'EUR',
                'base_price' => 10.00,
            ],
            [
                'name' => 'Asia',
                'code' => 'ASIA',
                'base_price' => 20.00,
            ],
            [
                'name' => 'America',
                'code' => 'AMER',
                'base_price' => 30.00,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
