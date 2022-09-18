<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'System Admin',
            'phone' => '0912345678',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('system_admin');

        $user = User::create([
            'name' => 'Referee',
            'phone' => '09123456789',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('referee');

        $user = User::create([
            'name' => 'Agent',
            'phone' => '09123456788',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('agent');
    }
}
