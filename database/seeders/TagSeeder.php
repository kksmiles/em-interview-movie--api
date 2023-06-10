<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'id' => 1,
                'name' => 'Thrilling',
            ],
            [
                'id' => 2,
                'name' => 'Rom-com',
            ],
            [
                'id' => 3,
                'name' => 'Sci-fi',
            ],
            [
                'id' => 4,
                'name' => 'Historical',
            ],
            [
                'id' => 5,
                'name' => 'Psychological',
            ],
            [
                'id' => 6,
                'name' => 'Epic',
            ],
            [
                'id' => 7,
                'name' => 'Horror',
            ],
            [
                'id' => 8,
                'name' => 'Inspirational',
            ],
            [
                'id' => 9,
                'name' => 'Satire',
            ],
            [
                'id' => 10,
                'name' => 'Psychological',
            ],
        ];
        Tag::insert($tags);
    }
}
