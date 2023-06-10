<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoviePictureController\FetchRequest;
use Illuminate\Support\Facades\Storage;

/**
 * @group Movie Picture management
 *
 * APIs for fetching movie pictures
 */
class MoviePictureController extends Controller
{
    /**
     * Fetch Movie Picture
     *
     * This endpoint will let you fetch the image of a given movie picture path
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/MoviePictureController/Fetch.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function fetch(FetchRequest $request)
    {
        $attributes = $request->validated();
        $path = $attributes['path'] ?? '404.jpg';

        Storage::exists($path) || abort(404);

        return Storage::response($path);
    }
}
