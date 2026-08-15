<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $categories = Category::select('name', 'id')
            ->paginate(5);

            return response()->json([
                'data' => $categories,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error fetching categories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {

            $this->validate($request);
    
            $category = Category::create([
                'name' => $request->name,
                /* 'user_id' => auth()->id(), */
            ]);
    
            return response()->json([
                'data' => $category,
            ], 201);
            
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error creating category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            
            $this->validate($request);
            
            $category->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'message' => 'Category updated successfully',
                'data' => $category,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating category',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {

            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting category',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function validate(Request $request): void
    {
        $request->validate([
           'name' => 'required|string|max:100',
        ]);
    }
}
