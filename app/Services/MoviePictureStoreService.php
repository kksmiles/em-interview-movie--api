<?php

namespace App\Services;

use App\Models\MoviePicture;

class MoviePictureStoreService
{
    public static function store($picture, $movieId)
    {
        $moviePicture = MoviePicture::create([
            'movie_id' => $movieId,
            'title' => $picture['title'],
            'description' => $picture['description'],
            'order' => $picture['order'],
            'path' => $picture['image']->store('movies'),
        ]);

        return $moviePicture;
    }

    public static function delete($id)
    {
        MoviePicture::find($id)->delete();
    }
}
