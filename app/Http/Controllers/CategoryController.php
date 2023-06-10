<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryController\IndexRequest;
use App\Http\Requests\CategoryController\StoreRequest;
use App\Http\Requests\CategoryController\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

/**
 * @group Category management
 *
 * APIs for managing categories
 */
class CategoryController extends Controller
{
    /**
     * Index Categories
     *
     * This endpoint will list all categories
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/CategoryController/Index.json
     */
    public function index(IndexRequest $request)
    {
        $attributes = $request->validated();
        $includeTrashed = $attributes['include_trashed'] ?? false;

        return CategoryResource::collection(Category::when($includeTrashed, function ($query) {
            return $query->withTrashed();
        })->paginate());
    }

    /**
     * Store Category
     *
     * This endpoint will create a new category
     *
     * @responseFile status=201 scenario="Success" app/Http/Responses/CategoryController/Store.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     */
    public function store(StoreRequest $request)
    {
        try {
            $attributes = $request->validated();
            Category::create($attributes);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully created',
        ], 201);
    }

    /**
     * Show category
     *
     * This endpoint will show the details of the category including favourite movies, categories and categories
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/CategoryController/Show.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully retrieved',
            'data' => new CategoryResource($category->load('movies')),
        ], 200);
    }

    /**
     * Update Category
     *

     * This endpoint will update a Category
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/CategoryController/Update.json
     * @responseFile status=400 scenario="Validation Error" app/Http/Responses/400.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function update(UpdateRequest $request, Category $category)
    {
        try {
            $attributes = $request->validated();
            $category->update($attributes);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong : '.$e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully updated',
        ], 200);
    }

    /**
     * Delete category
     *
     * This endpoint will delete a category
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/CategoryController/Destroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully trashed',
        ], 200);
    }

    /**
     * Restore category
     *
     * This endpoint will restore a category
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/CategoryController/Restore.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function restore(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully restored',
        ], 200);
    }

    /**
     * Force Destroy Category
     *
     * This endpoint will permanently delete a category
     *
     * @responseFile status=200 scenario="Success" app/Http/Responses/CategoryController/ForceDestroy.json
     * @responseFile status=404 scenario="Not Found" app/Http/Responses/404.json
     */
    public function forceDestroy(int $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully deleted',
        ], 200);
    }
}
