<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieController\IndexRequest;
use App\Http\Requests\MovieController\StoreRequest;
use App\Http\Requests\MovieController\UpdateRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MoviePictureStoreService;

/**
 * @group Movie management
 *
 * APIs for managing movies
 */
class MovieController extends Controller
{
    /**
     * Index Movies
     *
     * This endpoint will list all movies
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/MovieController/Index.json
     */
    public function index(IndexRequest $request)
    {
        $attributes = $request->validated();
        $includeTrash = $attributes['include_trashed'] ?? false;
        $strict = $attributes['strict_filter'] ?? false;

        $categoryIds = array_unique($attributes['category_ids'] ?? []);
        $hasCategoryFilter = count($categoryIds) > 0;
        $tagIds = array_unique($attributes['tag_ids'] ?? []);
        $hasTagFilter = count($tagIds) > 0;

        $withArr = [];
        if ($attributes['include_tags'] ?? false) {
            $withArr[] = 'tags';
        }
        if ($attributes['include_categories'] ?? false) {
            $withArr[] = 'categories';
        }
        if ($attributes['include_pictures'] ?? false) {
            $withArr[] = 'pictures';
        }

        return MovieResource::collection(
            Movie::with($withArr)
                ->when($includeTrash, function ($query) {
                    return $query->withTrashed();
                })
                ->when($strict, function ($query) use ($categoryIds, $hasCategoryFilter, $tagIds, $hasTagFilter) {
                    return $query->when($hasCategoryFilter, function ($query) use ($categoryIds) {
                        return $query->whereHas('categories', function ($query) use ($categoryIds) {
                            $query->whereIn('categories.id', $categoryIds);
                        }, '=', count($categoryIds));
                    })->when($hasTagFilter, function ($query) use ($tagIds) {
                        return $query->whereHas('tags', function ($query) use ($tagIds) {
                            $query->whereIn('tags.id', $tagIds);
                        }, '=', count($tagIds));
                    });
                })
                ->when(! $strict, function ($query) use ($categoryIds, $hasCategoryFilter, $tagIds, $hasTagFilter) {
                    return $query->when($hasCategoryFilter, function ($query) use ($categoryIds) {
                        return $query->whereHas('categories', function ($query) use ($categoryIds) {
                            $query->whereIn('categories.id', $categoryIds);
                        });
                    })->when($hasTagFilter, function ($query) use ($tagIds) {
                        return $query->orWhereHas('tags', function ($query) use ($tagIds) {
                            $query->whereIn('tags.id', $tagIds);
                        });
                    });
                })->paginate()
        );
    }

    /**
     * Store Movie
     *
     * This endpoint will create a new movie
     *
     * @responseFile status=201 scenario="Success" app/Http/Responses/MovieController/Store.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     */
    public function store(StoreRequest $request)
    {
        try {
            $attributes = $request->validated();
            $movie = Movie::create($attributes);
            $movie->categories()->sync($attributes['category_ids'] ?? []);
            $movie->tags()->sync($attributes['tag_ids'] ?? []);
            if (isset($attributes['pictures'])) {
                foreach ($attributes['pictures'] as $picture) {
                    MoviePictureStoreService::store($picture, $movie->id);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Movie successfully created',
        ], 201);
    }

    /**
     * Show Movie
     *
     * This endpoint will show a movie
     *
     * @responseFile status=201 scenario="Success" app/Http/Responses/MovieController/Show.json
     */
    public function show(Movie $movie)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Package successfully retrieved',
            'data' => new MovieResource($movie->load('categories', 'tags', 'pictures')),
        ], 200);
    }

    /**
     * Update Movie
     *
     * @authenticated
     * This endpoint will update a movie
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/MovieController/Update.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function update(UpdateRequest $request, Movie $movie)
    {
        try {
            $attributes = $request->validated();
            $movie->update($attributes);
            $movie->categories()->sync($attributes['category_ids'] ?? []);
            $movie->tags()->sync($attributes['tag_ids'] ?? []);
            if (isset($attributes['pictures'])) {
                foreach ($attributes['pictures'] as $picture) {
                    MoviePictureStoreService::store($picture, $movie->id);
                }
            }
            if (isset($attributes['remove_picture_ids'])) {
                foreach ($attributes['remove_picture_ids'] as $id) {
                    MoviePictureStoreService::delete($id);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Movie successfully updated',
        ], 201);
    }

    /**
     * Delete Movie
     *
     * This endpoint will delete a movie
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/MovieController/Destroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Movie successfully trashed',
        ], 200);
    }

    /**
     * Restore movie
     *
     * This endpoint will restore a movie
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/MovieController/Restore.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function restore(string $slug)
    {
        $movie = Movie::withTrashed()->where('slug', $slug)->firstOrFail();
        $movie->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Movie successfully restored',
        ], 200);
    }

    /**
     * Force Destroy movie
     *
     * This endpoint will permanently delete a movie
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/MovieController/ForceDestroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function forceDestroy(string $slug)
    {
        $movie = Movie::withTrashed()->where('slug', $slug)->firstOrFail();
        $movie->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Movie successfully deleted',
        ], 200);
    }
}
