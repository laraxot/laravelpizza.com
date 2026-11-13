<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Actions\File\CreateRelativeSymlinkAction;
use Modules\Xot\Actions\File\EnsureGitignoreEntriesAction;
use Safe\Exceptions\FilesystemException;

use function Safe\readlink;
use function Safe\realpath;
use function Safe\symlink;

class ModuleLinkCommand extends Command
{
    protected $signature = 'xot:module-link
                            {--module= : Nome del modulo specifico da linkare}
                            {--dry-run : Mostra le operazioni senza eseguirle}
                            {--force : Ricrea il link se la destinazione esiste gia\'}';

    protected $description = 'Crea i symlink public_html/assets/{modulo} verso Modules/{Modulo}/public';

    public function handle(): int
    {
        $modulesPath = base_path('Modules');
        $docroot = base_path('../public_html/assets');
        $filter = $this->option('module');
        $dryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        if (! File::isDirectory($modulesPath)) {
            $this->error("Directory moduli non trovata: {$modulesPath}");

            return self::FAILURE;
        }

        File::ensureDirectoryExists($docroot);

        $created = 0;
        $skipped = 0;

        foreach (File::directories($modulesPath) as $moduleDir) {
            if (! is_string($moduleDir)) {
                continue;
            }
            $module = basename($moduleDir);
            if (is_string($filter) && $filter !== '' && strcasecmp($module, $filter) !== 0) {
                continue;
            }

            $source = $moduleDir.DIRECTORY_SEPARATOR.'public';
            if (! File::isDirectory($source)) {
                $this->line("- {$module}: nessuna cartella public/, saltato");
                $skipped++;

                continue;
            }

            $link = $docroot.DIRECTORY_SEPARATOR.Str::lower($module);
            $result = $this->link($link, $source, $dryRun, $force);
            if ($result === 'linked') {
                $created++;
            } else {
                $skipped++;
            }
        }

        $this->info(($dryRun ? '[dry-run] ' : '')."Completato: {$created} link creati, {$skipped} saltati.");

        return self::SUCCESS;
    }

    private function link(string $link, string $source, bool $dryRun, bool $force): string
    {
        // Il link non si committa: la cartella del docroot ha un .gitignore che lo elenca (due righe per nome).
        if (! $dryRun) {
            $added = app(EnsureGitignoreEntriesAction::class)->execute(
                dirname($link).DIRECTORY_SEPARATOR.'.gitignore',
                basename($link),
                "# public_html/assets/<modulo> = ln -s ../../laravel/Modules/<Modulo>/public (php artisan xot:module-link)\n# Solo link creati in ogni installazione: non si committano. `<nome>/` = cartella reale, `<nome>` = symlink.",
            );
            if ($added !== []) {
                $this->line('- '.basename($link).': aggiunto a .gitignore ('.implode(', ', $added).')');
            }
        }

        if (is_link($link)) {
            $target = (string) readlink($link);
            // realpathOrFalse: false (non eccezione) se il link e' rotto.
            $resolved = $this->realpathOrFalse(
                str_starts_with($target, '/') ? $target : dirname($link).'/'.$target
            );
            if (app(CreateRelativeSymlinkAction::class)->isRelativeLinkTo($link, $source)) {
                $this->line('- '.basename($link).": link gia' corretto");

                return 'skipped';
            }
            // Stessa destinazione ma percorso assoluto: si riscrive relativo, senza bisogno di --force.
            $sameTarget = $resolved !== false && $resolved === $this->realpathOrFalse($source);
            if (! $sameTarget && ! $force) {
                $this->warn('- '.basename($link).": link esistente punta a {$target}, usa --force per sostituirlo");

                return 'skipped';
            }
            if (! $dryRun) {
                File::delete($link);
            }
        } elseif (File::exists($link)) {
            if (! $force) {
                $this->warn('- '.basename($link).': esiste una cartella reale, usa --force per sostituirla');

                return 'skipped';
            }
            if (! $dryRun) {
                File::moveDirectory($link, $link.'.bak-'.date('YmdHis'));
            }
        }

        $relative = app(CreateRelativeSymlinkAction::class)->relativeTarget($source, $link);
        $this->info(($dryRun ? '[dry-run] ' : '').'ln -s '.$relative.' '.\Str::after($link, base_path('../')));
        if (! $dryRun) {
            symlink($relative, $link);
        }

        return 'linked';
    }

    /**
     * realpath che restituisce false (non eccezione) se il percorso non esiste o il link e' rotto.
     */
    private function realpathOrFalse(string $path): string|false
    {
        try {
            return realpath($path);
        } catch (FilesystemException) {
            return false;
        }
    }
}
