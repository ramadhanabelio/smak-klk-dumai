<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CompanySeeder::class,
            EmployeeSeeder::class,
            DepartmentSeeder::class,
        ]);
    }
}
