<?php

namespace App\Console\Commands\Products;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductsShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all the products';

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
        // Get all the products
        $products = Product::orderBy('id', 'DESC')->get();

        $output = "\r\nID | Name | Price \r\n";

        // Fill the output variable with the categories
        foreach($products as $product) {
            $output .= $product->id . ' - ' . $product->name . ' - ' . $product->price . "\r\n";
        }
        // Print the output
        echo $output . "\r\n" ;
        return Command::SUCCESS;
    }
}
