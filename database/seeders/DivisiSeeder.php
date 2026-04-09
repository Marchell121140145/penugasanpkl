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
            ['nama' => 'Divisi IT'],
            ['nama' => 'Divisi Keuangan'],
            ['nama' => 'Divisi HRD'],
            ['nama' => 'Divisi Marketing'],
            ['nama' => 'Divisi Operasional'],
        ];

        foreach ($divisis as $divisi) {
            Divisi::firstOrCreate($divisi);
        }
    }
}
