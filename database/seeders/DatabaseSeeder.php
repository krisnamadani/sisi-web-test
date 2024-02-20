<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'id_user' => 1,
            'nama_user' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@email.com',
            'no_hp' => '081234567890',
            'wa' => '081234567890',
            'pin' => '123456',
            'id_jenis_user' => 1,
            'status_user' => 'active',
            'delete_mark' => '0',
            'create_by' => 1,
            'create_date' => date('Y-m-d H:i:s'),
            'update_by' => 1,
            'update_date' => date('Y-m-d H:i:s'),
        ]);
    }
}
