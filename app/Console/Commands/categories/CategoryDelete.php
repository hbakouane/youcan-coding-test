<?php

namespace App\Console\Commands\Categories;

use App\Models\Category;
use Illuminate\Console\Command;

class CategoryDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete {categoryId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a category by a given ID.';

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
        // Get the category by its ID
        $category = Category::find($this->argument('categoryId'));
        if ($category) {
            $category->delete();
            $this->info('Category deleted successfully.');
        } else {
            $this->error('Category not found.');
            if ($this->confirm('Do you want to show all the available categories?', true)) {
                // Show all the categories
                (new CategoriesShow())->handle();
            } else {
                $this->info("As you want dear tester!");
            }
        }
        return Command::SUCCESS;
    }
}
