<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role' => 'admin'],
            ['role' => 'pembimbing'],
            ['role' => 'pelaksana'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
