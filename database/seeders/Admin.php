<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'nomor_hp' => '0810000000',
            'nip' => '0000',
            'email' => 'admin@gmail.com',
            'role' => 'administrator',
            'password' => bcrypt('admin1234'),
            'divisi_id' => null,
            'foto_profile' => ''
        ]);
    }
}
