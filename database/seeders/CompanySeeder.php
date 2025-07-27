<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $companies = [
            ['code' => 'KLK', 'name' => 'PT. Kuala Lumpur Kepong'],
            ['code' => 'KJA', 'name' => 'PT. Kreasijaya Adhikarya'],
            ['code' => 'PDI', 'name' => 'PT. Prima Dumai Indobulking'],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
