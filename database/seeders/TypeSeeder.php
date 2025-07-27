<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = [
            'Surat Keluar',
            'Berita Acara',
            'Surat Perjanjian',
            'Surat Perintah Kerja',
            'Surat Edaran',
            'Surat Kuasa',
            'SK DIREKSI',
        ];

        $types = array_unique($types);

        foreach ($types as $type) {
            Type::create(['name' => $type]);
        }
    }
}
