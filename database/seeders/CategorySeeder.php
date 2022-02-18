<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\SubCategory;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Gastos', 'color' => 'danger', 'icon' => '-',
                'subCategories' => [
                    'Compromisos Bancarios', 'Salud y bienestar', 'Transporte', 'Hogar', 'Tecnología',
                    'Entretenimiento', 'Moda', 'Alimentación', 'Educación', 'Viajes', 'Otros'
                ]
            ],
            ['name' => 'Ingresos', 'color' => 'success', 'icon' => '+',
                'subCategories' => [
                    'Salario', 'Rentabilidad', 'Préstamos', 'Extras'
                ]
            ]
        ];

        foreach ($categories as $key => $category) {
            $subCategories = $category['subCategories'];
            unset($category['subCategories']);

            $categoryCreate = Category::create($category);

            foreach ($subCategories as $key => $subCategory) {
                $categoryCreate->subCategories()->saveMany([
                    new SubCategory(['name' => $subCategory])
                ]);
            }
        }
    }
}
