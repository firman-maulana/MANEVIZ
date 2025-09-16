<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Hapus admin lama jika ada
        Admin::where('email', 'yuka123@gmail.com')->delete();
        
        // Buat admin baru
        Admin::create([
            'username' => 'yuka',
            'email' => 'yuka@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        
        echo "Admin created successfully!\n";
        echo "Email: yuka@gmail.com\n";
        echo "Password: admin123\n";
    }
}