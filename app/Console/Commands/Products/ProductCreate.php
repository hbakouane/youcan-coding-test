<?php

namespace App\Console\Commands\Products;

use App\Console\Commands\Categories\CategoriesShow;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Models\Category;
use Illuminate\Console\Command;

class ProductCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {name} {description} {category_id} {price} {image}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Check if the category exists
        if (! Category::find($this->argument('category_id'))) {
            // Trigger an error
            $this->error("This category doesn't exist");
            return $this->warn("Run categories:show to see all the categories.");
        }
        // Then fill a request
        $request = new ProductRequest([
            'name' => $this->argument('name'),
            'description' => $this->argument('description'),
            'category_id' => $this->argument('category_id'),
            'price' => $this->argument('price'),
            'image' => $this->argument('image')
        ]);
        // And execute the store order
        (new ProductsController())->store($request);
        $this->info("Product was created successfully.");
        return Command::SUCCESS;
    }
}
