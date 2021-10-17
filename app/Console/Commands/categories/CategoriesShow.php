<?php

namespace App\Console\Commands\Categories;

use App\Models\Category;
use Illuminate\Console\Command;

class CategoriesShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all the categories.';
    
    /**
     * Categories
     *
     * @var array
     */
    public $categories = [];

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
     * Get the parent of a category from its id
     *
     * @param  mixed $parentId
     * @return void
     */
    public function getParentCategory($parentId)
    {
        // Filter the categories object we already have so that we won't need to execute another query
        $parentCategory = array_filter($categories->toArray(), function ($category) use($parentId) {
            return $category['id'] == $parentId;
        });
        return $parentCategory[1]['name'] ?? 'null';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all the categories
        $this->categories = Category::orderBy('id', 'DESC')->get();
        $output = "\r\nID | CATEGORY | PARENT \r\n";

        // Fill the output variable with the categories
        foreach($this->categories as $category) {
            $output .= $category->id . ' - ' . $category->name . ' - ' . $this->getParentCategory($category->parent) . "\r\n";
        }
        // Print the output
        echo $output . "\r\n" ;
        return Command::SUCCESS;
    }
}
