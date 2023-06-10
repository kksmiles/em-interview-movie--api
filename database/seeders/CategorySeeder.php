<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Action',
            ],
            [
                'id' => 2,
                'name' => 'Adventure',
            ],
            [
                'id' => 3,
                'name' => 'Animation',
            ],
            [
                'id' => 4,
                'name' => 'Biography',
            ],
            [
                'id' => 5,
                'name' => 'Comedy',
            ],
            [
                'id' => 6,
                'name' => 'Crime',
            ],
            [
                'id' => 7,
                'name' => 'Sci-Fi',
            ],
            [
                'id' => 8,
                'name' => 'Drama',
            ],
            [
                'id' => 9,
                'name' => 'Fantasy',
            ],
            [
                'id' => 10,
                'name' => 'Horror',
            ],
        ];

        Category::insert($categories);
    }
}
