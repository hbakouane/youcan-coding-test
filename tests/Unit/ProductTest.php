<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Storing product test
     *
     * @return void
     */
    public function test_it_stores_product()
    {
        // Get all categories
        $category = Category::first();
        if (! $category) {
            (new Category())->create(['name' => 'Test Category']);
        }
        $response = $this->postJson(route('api.v1.products.store'), [
            'name' => 'This is a product testing name',
            'description' => 'This is a product testing description',
            'price' => 98.85,
            'image' => UploadedFile::fake()->create('test-image.jpg'),
            'category_id' => $category->id
        ]);

        $response->assertStatus(201); // Assert that the object was created
    }
}
