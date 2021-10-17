<?php

namespace App\Console\Commands\Categories;

use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Requests\Api\V1\CategoryRequest;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class CategoryCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create {name} {parent?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Category';

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
        // Then fill a request
        $request = new CategoryRequest([
            'name' => $this->argument('name'),
            'parent' => $this->argument('parent')
        ]);
        // And execute the store order
        (new CategoriesController())->store($request);
        $this->info("Category " . $this->argument('name') . " was created successfully.");
        return Command::SUCCESS;
    }
}
