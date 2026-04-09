<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisiIds = Divisi::pluck('id')->toArray();
        if (empty($divisiIds)) {
            $divisiIds = [null];
        }

        // Buat 5 Pembimbing
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => 'pembimbing' . $i . '@example.com'],
                [
                    'name' => 'Pembimbing Dummy ' . $i,
                    'password' => Hash::make('password'),
                    'role_id' => 2, // Role Pembimbing
                    'divisi_id' => $divisiIds[array_rand($divisiIds)],
                ]
            );
        }

        // Buat 15 Pelaksana
        for ($i = 1; $i <= 15; $i++) {
            User::updateOrCreate(
                ['email' => 'pelaksana' . $i . '@example.com'],
                [
                    'name' => 'Pelaksana Dummy ' . $i,
                    'password' => Hash::make('password'),
                    'role_id' => 3, // Role Pelaksana
                    'divisi_id' => $divisiIds[array_rand($divisiIds)],
                ]
            );
        }
    }
}
