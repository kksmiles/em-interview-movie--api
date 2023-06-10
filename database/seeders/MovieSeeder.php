<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movie = Movie::create([
            'id' => 1,
            'slug' => 'the-matrix',
            'title' => 'The Matrix',
            'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
            'length_in_seconds' => 136 * 60,
            'released_at' => '1999-03-31 00:00:00',
            'available_until' => '2023-06-30 23:59:59',
        ]);
        $movie->categories()->attach([1, 3, 5]);
        $movie->tags()->attach([3, 6]);

        $movie = Movie::create([
            'id' => 2,
            'slug' => 'titanic',
            'title' => 'Titanic',
            'description' => 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.',
            'length_in_seconds' => 194 * 60,
            'released_at' => '1997-12-19 00:00:00',
            'available_until' => '2023-06-30 23:59:59',
        ]);
        $movie->categories()->attach([2, 4, 8]);
        $movie->tags()->attach([2, 8]);

        $movie = Movie::create([
            'id' => 3,
            'slug' => 'the-lord-of-the-rings-the-return-of-the-king',
            'title' => 'The Lord of the Rings: The Return of the King',
            'description' => 'The former Fellowship members prepare for the final battle. While Frodo and Sam approach Mount Doom to destroy the One Ring, they follow Gollum, unaware of the path he is leading them to.',
            'length_in_seconds' => 201 * 60,
            'released_at' => '2003-12-17 00:00:00',
            'available_until' => '2023-06-30 23:59:59',
        ]);
        $movie->categories()->attach([1, 2, 9]);
        $movie->tags()->attach([1, 6]);

        $movie = Movie::create([
            'id' => 4,
            'slug' => 'the-dark-knight',
            'title' => 'The Dark Knight',
            'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
            'length_in_seconds' => 152 * 60,
            'released_at' => '2008-07-18 00:00:00',
            'available_until' => '2023-06-30 23:59:59',
        ]);
        $movie->categories()->attach([1, 6, 10]);
        $movie->tags()->attach([1, 5]);

        $movie = Movie::create([
            'id' => 5,
            'slug' => 'star-wars-episode-v-the-empire-strikes-back',
            'title' => 'Star Wars: Episode V - The Empire Strikes Back',
            'description' => 'After the Rebels are brutally overpowered by the Empire on the ice planet Hoth, Luke Skywalker begins Jedi training with Yoda, while his friends are pursued by Darth Vader and a bounty hunter named Boba Fett all over the galaxy.',
            'length_in_seconds' => 124 * 60,
            'released_at' => '1980-06-20 00:00:00',
            'available_until' => '2023-06-30 23:59:59',
        ]);
        $movie->categories()->attach([1, 3, 7, 9]);
        $movie->tags()->attach([1, 3]);
    }
}
