<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Gastos'],
            ['name' => 'Ingresos'],
            ['name' => 'Tarjetas de credito']
        ];

        foreach ($categories as $key => $category) {
            Category::create($category);
        }
    }
}
