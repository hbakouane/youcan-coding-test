<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Resources\Api\V1\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get all the products
        $products = Product::with('categories')->orderBy($request->sortBy ?? 'id', $request->type ?? 'DESC')->paginate(5);
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
        $data = $request->only(Product::getRequiredFields());
        // Handle the product image uploading
        if ($request->hasFile('image')) {
            // Give the file a name
            $name = Str::random(99) . '.' . $request->file('image')->extension();
            // Upload the file
            $uploadedFile = Storage::putFileAs('public/uploads/products/images', $request->file('image'), $name);
            // Store the uploaded file's url
            $data['image'] = Storage::url($uploadedFile);
        }
        $createdProduct = (new Product())->create($data);
        // Handle the product categories that can be many not just one
        $createdProduct->categories()->attach(explode(',', $request->category_id));
        return new ProductResource($createdProduct);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Delete the selected product
        $product->delete();
        // Return no content after deleting
        return response()->noContent();
    }
}
