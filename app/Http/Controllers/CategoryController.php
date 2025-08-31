<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('books')->get();

        return response()->json([
            'message' => 'Categories loaded',
            'categories' => CategoryResource::collection($categories)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $field = $request->validated();

        $category = Category::create($field);

        if($request->has('book_ids')){
            $category->books()->attach($request->book_ids);
        }

        return response()->json([
            'message' => 'category created successfully',
            'category' => CategoryResource::make($category)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'message' => 'category fetched successfully',
            'category' => CategoryResource::make($category)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        if($request->has('book_ids')){
            $category->books()->sync($request->book_ids);
        }

        return response()->json([
            'message' => 'category updated successfully',
            'category' => CategoryResource::make($category)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->books()->detach();

        $category->delete();

        return response()->json([   
            'message' => 'category deleted successfully',
        ], 200);
    }
}
