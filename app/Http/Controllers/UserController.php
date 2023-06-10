<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserController\IndexRequest;
use App\Http\Requests\UserController\StoreRequest;
use App\Http\Requests\UserController\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

/**
 * @group User management
 *
 * APIs for managing users
 */
class UserController extends Controller
{
    /**
     * Index Users
     *
     * This endpoint will list all users
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/UserController/Index.json
     */
    public function index(IndexRequest $request)
    {
        $attributes = $request->validated();
        $includeTrashed = $attributes['include_trashed'] ?? false;

        return UserResource::collection(User::when($includeTrashed, function ($query) {
            return $query->withTrashed();
        })->paginate());
    }

    /**
     * Store User
     *
     * This endpoint will create a new user
     *
     * @responseFile status=201 scenario="Success" app/Http/Responses/UserController/Store.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     */
    public function store(StoreRequest $request)
    {
        try {
            $attributes = $request->validated();
            $user = User::create($attributes);
            $user->favourite_categories()->sync($attributes['category_ids'] ?? []);
            $user->favourite_tags()->sync($attributes['tag_ids'] ?? []);
            $user->favourite_movies()->sync($attributes['movie_ids'] ?? []);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully created',
        ], 201);
    }

    /**
     * Show user
     *
     * This endpoint will show the details of the user including favourite movies, categories and tags
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/UserController/Show.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User successfully retrieved',
            'data' => new UserResource($user->load(['favourite_movies', 'favourite_categories', 'favourite_tags'])),
        ], 200);
    }

    /**
     * Update User
     *

     * This endpoint will update a User
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/UserController/Update.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function update(UpdateRequest $request, User $user)
    {
        try {
            $attributes = $request->validated();
            $user->update($attributes);
            $user->favourite_categories()->sync($attributes['category_ids'] ?? []);
            $user->favourite_tags()->sync($attributes['tag_ids'] ?? []);
            $user->favourite_movies()->sync($attributes['movie_ids'] ?? []);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully updated',
        ], 200);
    }

    /**
     * Delete user
     *
     * This endpoint will delete a user
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/UserController/Destroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully trashed',
        ], 200);
    }

    /**
     * Restore user
     *
     * This endpoint will restore a user
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/UserController/Restore.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully restored',
        ], 200);
    }

    /**
     * Force Destroy user
     *
     * This endpoint will permanently delete a user
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/UserController/ForceDestroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function forceDestroy(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully deleted',
        ], 200);
    }
}
