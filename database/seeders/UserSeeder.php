<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();
            $user->favourite_movies()->attach([rand(1, 3), rand(4, 5)]);
            $user->favourite_categories()->attach([rand(1, 3), rand(4, 7), rand(8, 10)]);
            $user->favourite_tags()->attach([rand(1, 3), rand(4, 7), rand(8, 10)]);
        }
    }
}
