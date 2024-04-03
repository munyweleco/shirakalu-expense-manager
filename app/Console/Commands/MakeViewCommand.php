<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {view}'; //overrides the default command

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new blade template';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $view = $this->argument('view');
        $path = $this->viewPath($view);
        $this->createDir($path);
        if (File::exists($path)) {
            $this->error("File {$path} already exists!");
            return;
        }
        File::put($path, $path);
        $this->info("File {$path} created.");
    }

    /**
     * Get the view full path.
     *
     * @param string $view
     *
     * @return string
     */
    public function viewPath(string $view): string
    {
        $view = str_replace('.', '/', $view) . '.blade.php';
        return "resources/views/{$view}";
    }

    /**
     * Create a view directory if it does not exist.
     *
     * @param $path
     */
    private function createDir($path): void
    {
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}
