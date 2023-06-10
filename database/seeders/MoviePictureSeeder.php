<?php

namespace Database\Seeders;

use App\Models\MoviePicture;
use Illuminate\Database\Seeder;

class MoviePictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movie_pictures = [
            [
                'id' => 1,
                'movie_id' => 1,
                'title' => 'The matrix one',
                'description' => 'First picture of the matrix movie',
                'order' => 1,
                'path' => 'https://placekitten.com/320/180',
            ],
            [
                'id' => 2,
                'movie_id' => 1,
                'title' => 'The matrix two',
                'description' => 'Second picture of the matrix movie',
                'order' => 2,
                'path' => 'https://placekitten.com/336/189',
            ],
            [
                'id' => 3,
                'movie_id' => 2,
                'title' => 'The titanic one',
                'description' => 'First picture of the titanic movie',
                'order' => 1,
                'path' => 'https://placekitten.com/480/240',
            ],
            [
                'id' => 4,
                'movie_id' => 2,
                'title' => 'The titanic two',
                'description' => 'Second picture of the titanic movie',
                'order' => 2,
                'path' => 'https://placekitten.com/464/231',
            ],
            [
                'id' => 5,
                'movie_id' => 2,
                'title' => 'The titanic three',
                'description' => 'Third picture of the titanic movie',
                'order' => 3,
                'path' => 'https://placekitten.com/496/249',
            ],
            [
                'id' => 6,
                'movie_id' => 3,
                'title' => 'The lord of the rings one',
                'description' => 'First picture of the lord of the rings movie',
                'order' => 1,
                'path' => 'https://placekitten.com//640/360',
            ],
            [
                'id' => 7,
                'movie_id' => 4,
                'title' => 'The dark knight one',
                'description' => 'First picture of the dark knight movie',
                'order' => 1,
                'path' => 'https://placekitten.com/800/450',
            ],
        ];
        MoviePicture::insert($movie_pictures);
    }
}
