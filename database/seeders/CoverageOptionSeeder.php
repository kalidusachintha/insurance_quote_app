<?php

namespace Database\Seeders;

use App\Models\CoverageOption;
use Illuminate\Database\Seeder;

class CoverageOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coverageOptions = [
            [
                'name' => 'Medical Expenses',
                'code' => 'MEDICAL',
                'price' => 20.00,
            ],
            [
                'name' => 'Trip Cancellation',
                'code' => 'CANCEL',
                'price' => 30.00,
            ],
        ];

        foreach ($coverageOptions as $option) {
            CoverageOption::create($option);
        }
    }
}
