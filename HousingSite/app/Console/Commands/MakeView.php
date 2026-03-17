<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Example usage:
     * php artisan make:view dashboard.index
     */
    protected $signature = 'make:view {name}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new Blade view file (and folders if needed)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        // Replace dots with slashes to support subfolders
        $path = resource_path('views/' . str_replace('.', '/', $name) . '.blade.php');

        // Create folder if it doesn't exist
        $directory = dirname($path);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Create the file if it doesn’t exist
        if (File::exists($path)) {
            $this->error('View already exists!');
            return;
        }

        File::put($path, "<!-- View: $name -->");
        $this->info("View [$name] created successfully at: $path");
    }
}
