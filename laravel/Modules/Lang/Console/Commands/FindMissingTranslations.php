<?php

declare(strict_types=1);

namespace Modules\Lang\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\shell_exec;

class FindMissingTranslations extends Command
{
    protected $signature = 'translations:missing 
                            {locale : The locale to check for missing translations}
                            {--path= : Path to scan for translations}
                            {--json : Output as JSON}';

    protected $description = 'Find missing translations in the application';

    public function handle(): int
    {
        $localeArg = $this->argument('locale');
        $pathOption = $this->option('path');

        Assert::string($localeArg, 'Il parametro "locale" deve essere una stringa');

        $locale = $localeArg;
        $path = is_string($pathOption) ? $pathOption : app()->langPath("{$locale}");
        Assert::string($path, 'Il percorso deve essere una stringa');

        if (! File::exists($path)) {
            $this->error("Translation directory not found: {$path}");

            return 1;
        }

        $missing = $this->findMissingTranslations($path, $locale);

        if ($this->option('json')) {
            $jsonOutput = json_encode($missing, JSON_PRETTY_PRINT);
            $this->output->write($jsonOutput);

            return 0;
        }

        if (empty($missing)) {
            $this->info("No missing translations found in {$locale}.");

            return 0;
        }

        $this->info("Missing translations in {$locale}:");
        $this->table(['Key', 'File', 'Occurrences'], $missing);

        return 0;
    }

    /**
     * @return array<int, array<string, string|int>>
     */
    protected function findMissingTranslations(string $path, string $locale): array
    {
        $missing = [];
        $files = $this->getPhpFiles($path);

        foreach ($files as $file) {
            $relativePath = Str::after($file, $path.DIRECTORY_SEPARATOR);
            Assert::string($relativePath, 'Il percorso relativo deve essere una stringa');
            $relativePath = str_replace(DIRECTORY_SEPARATOR, '.', $relativePath);
            $namespace = str_replace('.php', '', $relativePath);

            $translations = require $file;
            Assert::isArray($translations, 'Le traduzioni devono essere un array');
            /** @var array<string, mixed> $translations */
            $missing = array_merge(
                $missing,
                $this->checkArrayForMissing($translations, $namespace, $file)
            );
        }

        return $missing;
    }

    /**
     * @param  array<string, mixed>  $array
     * @return array<int, array<string, string|int>>
     */
    protected function checkArrayForMissing(array $array, string $namespace, string $file, string $parentKey = ''): array
    {
        $missing = [];

        foreach ($array as $key => $value) {
            Assert::string($key, 'Le chiavi delle traduzioni devono essere stringhe');
            $currentKey = $parentKey ? "{$parentKey}.{$key}" : $key;

            if (is_array($value)) {
                // $value è già array perché verificato con is_array()
                /** @var array<string, mixed> $value */
                $missing = array_merge(
                    $missing,
                    $this->checkArrayForMissing($value, $namespace, $file, $currentKey)
                );
            } elseif ($value === '' || $value === null) {
                $missing[] = [
                    'key' => $namespace.'.'.$currentKey,
                    'file' => $file,
                    'occurrences' => $this->findOccurrences($namespace.'.'.$currentKey),
                ];
            }
        }

        return $missing;
    }

    protected function findOccurrences(string $key): int
    {
        $pattern = "__('".str_replace('.', '\\.', $key)."')";
        $command = "grep -r \"{$pattern}\" ".base_path().' --include="*.php" --include="*.blade.php"';

        try {
            $result = shell_exec($command);
            if ($result === null) {
                return 0;
            }

            // shell_exec restituisce string|null, dopo il controllo null è sempre string
            return count(explode("\n", trim($result)));
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * @return array<int, string>
     */
    protected function getPhpFiles(string $path): array
    {
        $files = File::allFiles($path);
        $phpFiles = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && $file->getFilename() !== 'validation.php') {
                $phpFiles[] = $file->getPathname();
            }
        }

        return $phpFiles;
    }
}
