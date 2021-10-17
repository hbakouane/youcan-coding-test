<?php

namespace App\Console\Commands\Products;

use App\Http\Controllers\Api\V1\ProductsController;
use App\Models\Product;
use Illuminate\Console\Command;

class ProductDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete {productId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a product by a gived ID';

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
        // Get the Product by its ID
        $product = Product::find($this->argument('productId'));
        if ($product) {
            // Delete the Product if exists
            (new ProductsController())->destroy($product);
            $this->info('Product deleted successfully.');
        } else {
            $this->error('Product not found.');
            if ($this->confirm('Do you want to show all the available products?', true)) {
                // Show all the products
                (new ProductsShow())->handle();
            } else {
                $this->info("As you want dear tester!");
            }
        }
        return Command::SUCCESS;
    }
}
