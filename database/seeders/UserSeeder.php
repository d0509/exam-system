<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('admin');


        $user1 = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $user1->assignRole('teacher');

        $user2 = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $user2->assignRole('student');
    }
}
