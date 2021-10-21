<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new service';

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
        // Get the model name
        $model = $this->argument('model') ?? 'Model';
        $path = "App/Http/Services/";
        // The content of the new created service
        $context = "<?php

namespace App\Http\Services;
        
use App\Models\\" . $model . ";\r\n\r\n" . 
        
"class $model" . "Service extends Service
{
    public $" . "model = $model::class;
}";
        $filename = $model . 'Service.php';
        // Create a new file
        if (!file_exists($path . $filename)) {
            // Create the file
            if (fopen($path . $filename, 'w')) {
                $this->info("Service created successfully.");
            } else {
                $this->error("Something went wrong with the file creation.");
            }
            // Writing on the file
            fwrite(fopen($path . $filename, 'w'), $context);
        } else {
            $this->warn('This Service already exists.');
        }
        return Command::SUCCESS;
    }
}
