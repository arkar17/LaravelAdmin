<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' =>'system_admin',
        'guard_name' => 'web'
       ]);

        Role::create(['name' =>'referee',
        'guard_name' => 'web'
            ]);

        Role::create(['name' =>'agent',
        'guard_name' => 'web'
            ]);

        Role::create(['name' =>'guest',
        'guard_name' => 'web'
            ]);
    }
}
