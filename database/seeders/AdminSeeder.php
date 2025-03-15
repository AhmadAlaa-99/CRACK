<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        Permission::create(['name' => 'admin']);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'city' => 'Damascus',
            'last_login_ip'=>'193.168.16.82',
            'password' => Hash::make('admin123'),
        ]);

        $user->assignRole('admin');
    }
}
