<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoryRequest;
use App\Http\Services\CategoryService;

class CategoriesController extends Controller
{    
    public $categoryService;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the categories
        $categories = $this->categoryService->getAll();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // Get only the necessary data to fill
        $data = $request->only($this->categoryService->getRequiredFields());
        // Persist a new category to the database
        $category = $this->categoryService->create($data);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete the selected category
        $this->categoryService->delete($id);
        // Return no content after deleting
        return response()->noContent();
    }
}
