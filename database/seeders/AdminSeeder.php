<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@admin.admin',
            'email_verified_at' => now(),
            'password' => bcrypt('aaaaaaaa'),
            'role' => 'a',
            'completeprofile' => 1
        ]);


    }
}
