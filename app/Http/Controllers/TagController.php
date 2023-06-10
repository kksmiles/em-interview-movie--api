<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagController\IndexRequest;
use App\Http\Requests\TagController\StoreRequest;
use App\Http\Requests\TagController\UpdateRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;

/**
 * @group Tag management
 *
 * APIs for managing tags
 */
class TagController extends Controller
{
    /**
     * Index Tags
     *
     * This endpoint will list all tags
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/TagController/Index.json
     */
    public function index(IndexRequest $request)
    {
        $attributes = $request->validated();
        $includeTrashed = $attributes['include_trashed'] ?? false;

        return TagResource::collection(Tag::when($includeTrashed, function ($query) {
            return $query->withTrashed();
        })->paginate());
    }

    /**
     * Store Tag
     *
     * This endpoint will create a new tag
     *
     * @responseFile status=201 scenario="Success" app/Http/Responses/TagController/Store.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     */
    public function store(StoreRequest $request)
    {
        try {
            $attributes = $request->validated();
            Tag::create($attributes);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully created',
        ], 201);
    }

    /**
     * Show tag
     *
     * This endpoint will show the details of the tag including favourite movies, categories and tags
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/TagController/Show.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function show(Tag $tag)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully retrieved',
            'data' => new TagResource($tag->load('movies')),
        ], 200);
    }

    /**
     * Update Tag
     *
     * This endpoint will update a Tag
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/TagController/Update.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        try {
            $attributes = $request->validated();
            $tag->update($attributes);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully updated',
        ], 200);
    }

    /**
     * Delete tag
     *
     * This endpoint will delete a tag
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/TagController/Destroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully trashed',
        ], 200);
    }

    /**
     * Restore tag
     *
     * This endpoint will restore a tag
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/TagController/Restore.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function restore(int $id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully restored',
        ], 200);
    }

    /**
     * Force Destroy tag
     *
     * This endpoint will permanently delete a tag
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/TagController/ForceDestroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function forceDestroy(int $id)
    {
        $tag = Tag::withTrashed()->findOrFail($id);
        $tag->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully deleted',
        ], 200);
    }
}
