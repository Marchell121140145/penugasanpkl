<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisis = [
            ['nama' => 'Divisi SSGS'],
            ['nama' => 'Divisi BGES'],
            ['nama' => 'Divisi HERO'],

        ];

        foreach ($divisis as $divisi) {
            Divisi::firstOrCreate($divisi);
        }
    }
}
