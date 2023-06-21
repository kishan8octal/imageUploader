<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Categories = [
            ['name' => 'Teachnology'],
            ['name' => 'Marketing'],
            ['name' => 'B2B'],
        ];
        foreach ($Categories as $Category) {
            Category::create($Category);
        }
    }
}
