<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Small', 'description' => 'Small Storage Units', 'dimensions'=> '3 X 3 M', 'pricePerDay'=> '1000'],
            ['name' => 'Medium', 'description' => 'Medium Storage Units', 'dimensions'=> '6 X 6 M', 'pricePerDay'=> '2000'],
            ['name' => 'Large', 'description' => 'Large Storage Units', 'dimensions'=> '9 X 9 M', 'pricePerDay'=> '3000'],
        ];

        Category::insert($categories);
    }
}
