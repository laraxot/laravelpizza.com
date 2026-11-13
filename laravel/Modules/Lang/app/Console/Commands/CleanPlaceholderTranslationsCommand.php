<?php

declare(strict_types=1);

namespace Modules\Lang\Console\Commands;

use Illuminate\Console\Command;
use Modules\Lang\Actions\CleanPlaceholderTranslationsAction;
use Nwidart\Modules\Facades\Module;

/**
 * php artisan lang:clean-placeholders            tutti i moduli
 * php artisan lang:clean-placeholders Geo User   solo questi
 * php artisan lang:clean-placeholders --dry-run  elenca soltanto
 */
class CleanPlaceholderTranslationsCommand extends Command
{
    /** @var string */
    protected $signature = 'lang:clean-placeholders {modules?* : Nomi dei moduli (default: tutti)} {--dry-run : Elenca senza modificare}';

    /** @var string */
    protected $description = 'Toglie dai file di lingua dei moduli le traduzioni segnaposto (testo uguale al nome del campo)';

    public function handle(CleanPlaceholderTranslationsAction $action): int
    {
        /** @var list<string> $requested */
        $requested = (array) $this->argument('modules');
        $names = $requested !== [] ? $requested : array_keys(Module::all());
        $dryRun = (bool) $this->option('dry-run');
        $totalFiles = 0;
        $totalRemoved = 0;

        foreach ($names as $name) {
            $module = Module::find($name);
            if ($module === null) {
                $this->warn("Modulo {$name} non trovato");

                continue;
            }
            $report = $action->execute($module->getPath().'/lang', $dryRun);
            if ($report['files'] === []) {
                continue;
            }
            $this->line(\sprintf('%s: %d file, %d voci', $module->getName(), \count($report['files']), $report['removed']));
            $totalFiles += \count($report['files']);
            $totalRemoved += $report['removed'];
        }

        $this->info(\sprintf('%d file, %d voci rimosse%s', $totalFiles, $totalRemoved, $dryRun ? ' (dry-run)' : ''));

        return self::SUCCESS;
    }
}
