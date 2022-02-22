<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

use App\Helper\UiAvatar;
use App\Models\SubCategory;

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
        $sub_categories = SubCategory::pluck('id')->all();

        \App\Models\User::factory(10)->create()->each(function($user) use ($roles, $sub_categories) {
            $user->assignRole(Arr::random($roles));

            // Avatar
            $avatarUrl = UiAvatar::avatar($user->name);
            $user->update(['photo' => $avatarUrl]);
            
            $movement = \App\Models\Movement::factory(40)->data($user->id, $sub_categories)->create();
        });

    }
}
