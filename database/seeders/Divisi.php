<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Divisi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::insert([
            ['kode' => 'TDE' ,'divisi' => 'Perencanaan'],
            ['kode' => 'EDR' ,'divisi' => 'Pengadaan & Pengembangan'],
            ['kode' => 'DAS' ,'divisi' => 'Operasional TI'],
            ['kode' => 'GGWP' ,'divisi' => 'Pengamanan Informasi'],
            ['kode' => 'EZ' ,'divisi' => 'MIS'],
            ['kode' => 'GE' ,'divisi' => 'E-Banking'],
            ['kode' => 'EG' ,'divisi' => 'End User Computing'],
        ]);
    }
}
