<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('categories')->get();

        return response()->json([
            'message' => 'Books loaded',
            'books' => BookResource::collection($books)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $fields = $request->validated();


        if ($request->hasFile('cover_image')) {

            $path = $request->file('cover_image')->store('images', 'public');

            $fields['cover_image'] = $path;
        }

        $book = Book::create($fields);

        if($request->has('category_ids')){
            $book->categories()->attach($request->category_ids);
        }

        return response()->json([
            'message' => 'Book added successfully',
            'book' => BookResource::make($book)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);

        return response()->json([
            'message' => 'Book fetched successfully',
            'book' => BookResource::make($book)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBookRequest $request, string $id)
    {

        $book = Book::findOrFail($id);

        $fields = $request->validated();


        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $fields['cover_image'] = $request->file('cover_image')->store('images', 'public');
        }

        $book->update($fields);

        if($request->has('category_ids')){
            $book->categories()->sync($request->category_ids);
        }

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => BookResource::make($book)
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ], 200);
    }
}
