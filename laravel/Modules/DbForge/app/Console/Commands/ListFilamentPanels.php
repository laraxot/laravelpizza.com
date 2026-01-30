<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Nwidart\Modules\Facades\Module;

use function Safe\scandir;

class ListFilamentPanels extends Command
{
    protected $signature = 'filament:list-panels';

    protected $description = 'List all Filament panels in modules';

    public function handle(): int
    {
        $modules = Module::all();

        /** @var Collection<string, \Nwidart\Modules\Module> $modules */
        foreach ($modules as $moduleName => $module) {
            $providersPath = $module->getPath().'/Providers';
            if (! is_dir($providersPath)) {
                continue;
            }

            /** @var Collection<int, string> $scannedFiles */
            $scannedFiles = collect(scandir($providersPath));

            $providers = $scannedFiles
                ->filter(fn (string $file): bool => str_ends_with($file, 'ServiceProvider.php'));

            /** @var Collection<int, string> $providers */
            foreach ($providers as $provider) {
                $providerClass = "Modules\\{$moduleName}\\Providers\\".basename($provider, '.php');
                if (! class_exists($providerClass)) {
                    continue;
                }

                $this->info("Found panel in {$moduleName}: {$provider}");
            }
        }

        return Command::SUCCESS;
    }
}
