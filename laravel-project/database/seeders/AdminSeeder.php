<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Fatih',
            'email'=>"fatih@test.com",
            'password'=>bcrypt(123456),
            'is_admin'=>true
        ]);
    }
}
