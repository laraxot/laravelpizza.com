<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\CreateRelativeSymlinkAction;
use Safe\Exceptions\FilesystemException;
use Symfony\Component\Console\Attribute\AsCommand;

use function Safe\realpath;
use function Safe\unlink;

#[AsCommand(name: 'symlink:publish')]
class SymlinkPublishCommand extends Command
{
    protected $signature = 'symlink:publish
        {--force : Overwrite existing symlinks}
        {--dry-run : Show what would be created without creating}';

    protected $description = 'Create symlinks for modules/themes with public folders (excludes modules without public folder)';

    public function handle(): int
    {
        $modulesPath = base_path('Modules');
        $themesPath = base_path('Themes');
        $assetsPath = public_path('assets');

        $this->info('Scanning for modules and themes with public folders...');

        $created = [];
        $skipped = [];
        $errors = [];

        // Process modules
        $this->processDirectory($modulesPath, $assetsPath, 'modules', $created, $skipped, $errors);

        // Process themes
        $this->processDirectory($themesPath, $assetsPath, 'themes', $created, $skipped, $errors);

        // Report results
        if (count($created) > 0) {
            $this->newLine();
            $this->info('Created symlinks:');
            foreach ($created as $item) {
                $this->line("  <info>✓</info> {$item}");
            }
        }

        if (count($skipped) > 0) {
            $this->newLine();
            $this->comment('Skipped (no public folder):');
            foreach ($skipped as $item) {
                $this->line("  <comment>•</comment> {$item}");
            }
        }

        if (count($errors) > 0) {
            $this->newLine();
            $this->error('Errors:');
            foreach ($errors as $error) {
                $this->line("  <error>✗</error> {$error}");
            }

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Symlink publish completed successfully.');

        return self::SUCCESS;
    }

    /**
     * Process a directory (modules or themes) for public folder symlinks.
     *
     * @param  list<string>  $created
     * @param  list<string>  $skipped
     * @param  list<string>  $errors
     *
     * @param-out list<string> $created
     * @param-out list<string> $skipped
     * @param-out list<string> $errors
     */
    protected function processDirectory(
        string $sourcePath,
        string $targetBase,
        string $type,
        array &$created,
        array &$skipped,
        array &$errors
    ): void {
        if (! is_dir($sourcePath)) {
            return;
        }

        $force = (bool) $this->option('force');
        $dryRun = (bool) $this->option('dry-run');

        foreach (File::directories($sourcePath) as $dir) {
            if (! is_string($dir)) {
                continue;
            }

            $name = basename($dir);
            $publicDir = $dir.'/public';

            if (! is_dir($publicDir)) {
                $skipped[] = "{$type}/{$name} (no public folder)";

                continue;
            }

            // Modules go under the assets base, themes under public_html/themes/
            $targetDir = $type === 'modules' ? $targetBase : public_path('themes');
            $targetPath = $targetDir.'/'.$name;

            // A dry run must leave the filesystem untouched, target directory included.
            if (! $dryRun && ! is_dir($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $linker = app(CreateRelativeSymlinkAction::class);
            $isLink = is_link($targetPath);
            if ($isLink) {
                if ($linker->isRelativeLinkTo($targetPath, $publicDir)) {
                    $this->line("  <info>=</info> {$type}/{$name} already linked correctly");

                    continue;
                }
                // Same target through an absolute path: rewritten as relative, no --force needed.
                $resolvedTarget = $this->realpathOrFalse($targetPath);
                $sameTarget = $resolvedTarget !== false && $resolvedTarget === $this->realpathOrFalse($publicDir);
                if (! $sameTarget && ! $force) {
                    $errors[] = "{$type}/{$name}: symlink already exists at {$targetPath}";

                    continue;
                }
            } elseif (is_dir($targetPath) && ! $force) {
                $errors[] = "{$type}/{$name}: directory exists at {$targetPath}, use --force to overwrite";

                continue;
            }

            // Nothing is removed or created in a dry run (before, --force deleted the target even then).
            if ($dryRun) {
                $created[] = "{$type}/{$name} → {$publicDir}";

                continue;
            }

            try {
                // --force: replace the existing link; a real directory is never deleted, it is moved aside
                // (it lives under the document root and may hold files nobody else has).
                if ($isLink) {
                    unlink($targetPath);
                } elseif (is_dir($targetPath)) {
                    File::moveDirectory($targetPath, $targetPath.'.bak-'.date('YmdHis'));
                }

                $linker->execute($publicDir, $targetPath);
                $created[] = "{$type}/{$name} → {$targetPath}";
            } catch (\Throwable $e) {
                $errors[] = "{$type}/{$name}: {$e->getMessage()}";
            }
        }
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
