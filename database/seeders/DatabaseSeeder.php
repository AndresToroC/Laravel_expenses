<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

use App\Helper\UiAvatar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class, 
            CategorySeeder::class
        ]);

        $roles = Role::pluck('name')->all();

        \App\Models\User::factory(40)->create()->each(function($user) use ($roles) {
            $user->assignRole(Arr::random($roles));

            // Avatar
            $avatarUrl = UiAvatar::avatar($user->name);
            $user->update(['photo' => $avatarUrl]);
        });
    }
}
