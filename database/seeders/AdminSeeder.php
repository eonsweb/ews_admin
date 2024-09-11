<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new AdminUser;
        $admin->name = "admin";
        $admin->username = "admin";
        $admin->email = "admin@admin.com";
        $admin->password = Hash::make('password');
        $admin->remember_token = "";
        $admin->save();
    }
}
