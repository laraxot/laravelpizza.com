<?php

declare(strict_types=1);

namespace Modules\Lang\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Safe\json_decode;
use function Safe\json_encode;

use Webmozart\Assert\Assert;

class ConvertTranslations extends Command
{
    protected $signature = 'translations:convert 
                            {from : Current format (php|json)}
                            {to : Target format (php|json)}
                            {locale=it : Locale to convert}
                            {--path= : Custom path to translations}';

    protected $description = 'Convert translation files between PHP and JSON formats';

    public function handle(): int
    {
        $fromArg = $this->argument('from');
        $toArg = $this->argument('to');
        $localeArg = $this->argument('locale');
        $pathOption = $this->option('path');

        Assert::string($fromArg, 'Il parametro "from" deve essere una stringa');
        Assert::string($toArg, 'Il parametro "to" deve essere una stringa');
        Assert::string($localeArg, 'Il parametro "locale" deve essere una stringa');

        $from = strtolower($fromArg);
        $to = strtolower($toArg);
        $locale = $localeArg;
        $path = $pathOption ?: lang_path($locale);
        Assert::string($path, 'Il percorso deve essere una stringa');

        if (! in_array($from, ['php', 'json']) || ! in_array($to, ['php', 'json'])) {
            $this->error('Invalid format. Use "php" or "json"');

            return 1;
        }

        if ($from === $to) {
            $this->info('Source and target formats are the same. Nothing to do.');

            return 0;
        }

        if (! File::exists($path)) {
            $this->error("Directory not found: {$path}");

            return 1;
        }

        try {
            if ('php' === $from && 'json' === $to) {
                $this->phpToJson($path, $locale);
            } else {
                $this->jsonToPhp($path, $locale);
            }

            $this->info('\nConversion completed successfully!');

            return 0;
        } catch (\Exception $e) {
            $this->error('Error during conversion: '.$e->getMessage());

            return 1;
        }
    }

    protected function phpToJson(string $path, string $locale): void
    {
        /** @var array<string, array<string, mixed>> $translations */
        $translations = [];
        $files = File::files($path);

        foreach ($files as $file) {
            if ('php' === $file->getExtension() && 'validation.php' !== $file->getFilename()) {
                $key = $file->getFilenameWithoutExtension();
                $fileTranslations = require $file->getPathname();
                Assert::isArray($fileTranslations, 'Le traduzioni caricate devono essere un array');
                /* @var array<string, mixed> $fileTranslations */
                $translations[$key] = $fileTranslations;
            }
        }

        // Flatten the array
        /** @var array<string, mixed> $translationsForFlatten */
        $translationsForFlatten = $translations;
        $flattened = $this->flattenArray($translationsForFlatten);

        // Save to JSON
        $jsonPath = lang_path("{$locale}.json");
        // json_encode con JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE restituisce sempre string
        $jsonContent = json_encode($flattened, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        File::put($jsonPath, $jsonContent);

        $this->info("Converted PHP files to {$jsonPath}");
    }

    protected function jsonToPhp(string $path, string $locale): void
    {
        $jsonFile = lang_path("{$locale}.json");

        if (! File::exists($jsonFile)) {
            $this->error("JSON file not found: {$jsonFile}");

            return;
        }

        $jsonContent = File::get($jsonFile);
        Assert::string($jsonContent, 'Il contenuto del file JSON deve essere una stringa');
        $translations = json_decode($jsonContent, true);

        if (! is_array($translations)) {
            $this->error("Invalid JSON content in {$jsonFile}");

            return;
        }

        $nested = [];

        foreach ($translations as $key => $value) {
            Assert::string($key, 'Le chiavi delle traduzioni devono essere stringhe');
            $this->setNestedValue($nested, $key, $value);
        }

        // Save PHP files
        foreach ($nested as $file => $content) {
            // $file è già string perché $nested è array<string, mixed>
            $filePath = lang_path("{$locale}/{$file}.php");

            $content = "<?php\n\nreturn ".$this->varExport($content, true).";\n";
            File::ensureDirectoryExists(dirname($filePath));
            File::put($filePath, $content);

            $this->info("Created: {$filePath}");
        }
    }

    /**
     * @param array<string, mixed> $array
     *
     * @return array<string, string>
     */
    protected function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            Assert::string($key, 'Le chiavi degli array devono essere stringhe');
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value)) {
                // $value è già array perché verificato con is_array()
                /** @var array<string, mixed> $value */
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                Assert::string($value, 'I valori delle traduzioni devono essere stringhe');
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $array
     */
    protected function setNestedValue(array &$array, string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $k) {
            // $k è già string perché explode() restituisce array<int, string>
            if (! isset($current[$k]) || ! is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }

        $current = $value;
    }

    protected function varExport(mixed $var, bool $return = false): string
    {
        if (is_array($var)) {
            $toImplode = [];
            $isAssoc = array_keys($var) !== range(0, count($var) - 1);

            foreach ($var as $key => $value) {
                Assert::string($key, 'Le chiavi degli array devono essere stringhe');
                $key = $isAssoc ? "\n    '".addcslashes($key, "'\\")."' => " : '';
                $toImplode[] = $key.$this->varExport($value, true);
            }

            $code = '['.implode(', ', $toImplode)."\n]";

            return $code;
        }
        $export = var_export($var, true);
        Assert::string($export, 'var_export deve restituire una stringa');

        return $export;
    }
}
