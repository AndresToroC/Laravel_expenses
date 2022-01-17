<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'client', 'guard_name' => 'web']
        ];

        foreach ($roles as $key => $rol) {
            Role::create($rol);
        }
    }
}
