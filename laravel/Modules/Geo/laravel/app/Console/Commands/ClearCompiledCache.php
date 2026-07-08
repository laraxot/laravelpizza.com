<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearCompiledCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-compiled-safe {--gitignore : Preserve .gitignore file (default)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely clear compiled cache files while preserving .gitignore';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cachePath = base_path('bootstrap/cache');

        if (! File::exists($cachePath)) {
            $this->error("Cache directory does not exist: {$cachePath}");

            return Command::FAILURE;
        }

        $this->info("Clearing compiled cache files in {$cachePath}...");

        // Get all files in cache directory
        $files = File::files($cachePath);

        $deleted = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();

            // Skip .gitignore and .gitkeep files
            if (in_array($filename, ['.gitignore', '.gitkeep'], true)) {
                $this->line("  <fg=yellow>Skipped</>: {$filename}");
                $skipped++;

                continue;
            }

            // Only delete .php files
            if ($file->getExtension() === 'php') {
                File::delete($file->getPathname());
                $this->line("  <fg=green>Deleted</>: {$filename}");
                $deleted++;
            } else {
                $this->line("  <fg=gray>Ignored</>: {$filename} (not a PHP file)");
            }
        }

        $this->newLine();
        $this->info('Cache cleared successfully!');
        $this->table(
            ['Action', 'Count'],
            [
                ['Deleted', $deleted],
                ['Skipped', $skipped],
            ]
        );

        // Clear OPCache if available
        if (function_exists('opcache_reset')) {
            opcache_reset();
            $this->info('OPCache reset.');
        }

        return Command::SUCCESS;
    }
}
