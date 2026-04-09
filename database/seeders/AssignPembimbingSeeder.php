<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AssignPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelaksanas = User::where('role_id', 3)->get();
        
        foreach ($pelaksanas as $pelaksana) {
            // Coba cari pembimbing di divisi yang sama
            $pembimbing = User::where('role_id', 2)
                ->where('divisi_id', $pelaksana->divisi_id)
                ->inRandomOrder()
                ->first();
                
            // Jika tidak ada di divisi yang sama, cari pembimbing bebas
            if (!$pembimbing) {
                $pembimbing = User::where('role_id', 2)->inRandomOrder()->first();
            }
            
            if ($pembimbing) {
                $pelaksana->update([
                    'pembimbing_id' => $pembimbing->id
                ]);
            }
        }
    }
}
