<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * get all ie /api/categories
     */
    public function index()
    {
        $categories = Category::with('transactions')->get();

        return CategoryResource::collection($categories);
    }


    /**
     * Store a newly created resource in storage.
     * POST /api/categories
     */
    public function store(StoreCategoryRequest $request)
    {
        try{
            $validated = $request->validated();
            $validated['slug']=Str::slug($validated['name']);

            $category = Category::create($validated);

            return response()->json([
                'success'=>true,
                'message'=>'category created successfully',
                'data'=>$category
            ],201);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'success'=>false,
                'message'=>'Validation failed',
                'data'=>$e->errors()
            ],422);
        }
        catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>'Failed to create category',
                'data'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     * get /api/categories/{id}
     */
    public function show(string $id)
    {
        $category = Category::with('transactions')->findOrFail($id);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     * put /api/categories/{id}
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'success'=>false,
                'message'=>'category not found'
            ],404);
        }

        try{
            $validated= $request->validated();

            if(isset($validated['name'])){
                $validated['slug']=Str::slug($validated['name']);
            }

            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => $category
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error updating category',
                'error' => $e->getMessage()
            ], 500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
        
        try {
            $category->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
