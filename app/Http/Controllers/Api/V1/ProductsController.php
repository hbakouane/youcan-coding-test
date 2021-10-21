<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Resources\Api\V1\ProductResource;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get all the products
        $products = $this->productService->getPaginated(5, [$request->sorBy, $request->type], ['categories']);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // Get just the necessary data
        $data = $request->only($this->productService->getRequiredFields());
        // Handle the product image uploading
        if ($request->hasFile('image')) {
            // Give the file a name
            $name = Str::random(99) . '.' . $request->file('image')->extension();
            // Upload the file
            $uploadedFile = Storage::putFileAs('public/uploads/products/images', $request->file('image'), $name);
            // Store the uploaded file's url
            $data['image'] = Storage::url($uploadedFile);
        }
        $createdProduct = $this->productService->create($data);
        // Handle the product categories that can be many not just one
        $createdProduct->categories()->attach(explode(',', $request->category_id));
        return new ProductResource($createdProduct);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete the selected product
        $this->productService->delete($id);
        // Return no content after deleting
        return response()->noContent();
    }
}
