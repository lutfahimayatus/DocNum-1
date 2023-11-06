<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::insert([
            ['desc' => 'Perencanaan'],
            ['desc' => 'Pengadaan & Pengembangan'],
            ['desc' => 'Operasional TI'],
            ['desc' => 'Pengamanan Informasi'],
            ['desc' => 'MIS'],
            ['desc' => 'E-Banking'],
            ['desc' => 'End User Computing'],
        ]);
    }
}
