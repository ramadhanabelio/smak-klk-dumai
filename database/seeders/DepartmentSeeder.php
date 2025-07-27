<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departments = [
            ['code' => 'IT', 'name' => 'Teknologi Informasi'],
            ['code' => 'HRD', 'name' => 'Human Resource Development'],
            ['code' => 'MTC', 'name' => 'Maintenance'],
            ['code' => 'FNC', 'name' => 'Finance'],
        ];

        foreach ($departments as $dept) {
            $department = Department::create($dept);

            Division::create([
                'code' => $dept['code'] . '-A',
                'name' => 'Divisi A - ' . $dept['name'],
                'department_id' => $department->id,
            ]);
            Division::create([
                'code' => $dept['code'] . '-B',
                'name' => 'Divisi B - ' . $dept['name'],
                'department_id' => $department->id,
            ]);
        }
    }
}
