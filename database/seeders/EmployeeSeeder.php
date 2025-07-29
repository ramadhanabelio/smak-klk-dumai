<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Rizki Saputra',
            'email' => 'rizki@klk.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti@kja.com',
            'password' => bcrypt('password'),
        ]);

        $user3 = User::create([
            'name' => 'Dian Firmansyah',
            'email' => 'dian@pdi.com',
            'password' => bcrypt('password'),
        ]);

        $itDivision = Division::where('code', 'IT-A')->first();
        $hrdDivision = Division::where('code', 'HRD-A')->first();
        $fncDivision = Division::where('code', 'FNC-A')->first();

        Employee::create([
            'user_id' => $user1->id,
            'division_id' => $itDivision->id,
            'employee_number' => 'EMP001',
            'name' => 'Rizki Saputra',
            'phone_number' => '081234567891',
            'place_of_birth' => 'Dumai',
            'date_of_birth' => '1995-08-15',
        ]);

        Employee::create([
            'user_id' => $user2->id,
            'division_id' => $hrdDivision->id,
            'employee_number' => 'EMP002',
            'name' => 'Siti Rahmawati',
            'phone_number' => '081234567892',
            'place_of_birth' => 'Dumai',
            'date_of_birth' => '1996-09-20',
        ]);

        Employee::create([
            'user_id' => $user3->id,
            'division_id' => $fncDivision->id,
            'employee_number' => 'EMP003',
            'name' => 'Dian Firmansyah',
            'phone_number' => '081234567893',
            'place_of_birth' => 'Dumai',
            'date_of_birth' => '1994-11-03',
        ]);
    }
}
