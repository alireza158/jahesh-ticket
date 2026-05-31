<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['phone' => '09111111111'],
            [
                'name' => 'مدیر مجموعه جهش',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
