<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

class SyncTranslationsAction
{
    use QueueableAction;

    /**
     * Sincronizza le traduzioni da una lingua sorgente a lingue target.
     *
     * @param string        $sourceLang     Lingua sorgente (default: 'it')
     * @param array<string> $targetLangs    Lingue target (default: ['en', 'de'])
     * @param string|null   $specificModule Modulo specifico (opzionale)
     *
     * @return array<string, mixed> Risultato della sincronizzazione
     */
    public function execute(
        string $sourceLang = 'it',
        array $targetLangs = ['en', 'de'],
        ?string $specificModule = null,
    ): array {
        $modulesPath = base_path('Modules');
        $modules = $specificModule ? [$specificModule] : $this->getModules($modulesPath);

        $results = [
            'total_modules' => 0,
            'total_files' => 0,
            'total_translations' => 0,
            'modules' => [],
        ];

        foreach ($modules as $module) {
            $moduleResults = $this->syncModule($module, $sourceLang, $targetLangs);
            $results['modules'][$module] = $moduleResults;
            $results['total_files'] += is_numeric($moduleResults['files_processed'] ?? null)
                ? ((int) $moduleResults['files_processed'])
                : 0;
            $results['total_translations'] += is_numeric($moduleResults['translations_added'] ?? null)
                ? ((int) $moduleResults['translations_added'])
                : 0;
            ++$results['total_modules'];
        }

        return $results;
    }

    /**
     * Sincronizza le traduzioni per un modulo specifico.
     *
     * @param string        $module      Nome del modulo
     * @param string        $sourceLang  Lingua sorgente
     * @param array<string> $targetLangs Lingue target
     *
     * @return array<string, mixed> Risultato per il modulo
     */
    private function syncModule(string $module, string $sourceLang, array $targetLangs): array
    {
        $moduleLangPath = base_path("Modules/{$module}/lang");

        if (! File::exists($moduleLangPath)) {
            return [
                'status' => 'skipped',
                'reason' => 'No lang directory',
                'files_processed' => 0,
                'translations_added' => 0,
            ];
        }

        $sourcePath = "{$moduleLangPath}/{$sourceLang}";
        if (! File::exists($sourcePath)) {
            return [
                'status' => 'skipped',
                'reason' => "Source language {$sourceLang} not found",
                'files_processed' => 0,
                'translations_added' => 0,
            ];
        }

        $sourceFiles = File::glob("{$sourcePath}/*.php");
        $filesProcessed = 0;
        $translationsAdded = 0;

        foreach ($sourceFiles as $sourceFile) {
            $fileName = basename((string) $sourceFile);
            $sourceTranslations = $this->loadTranslations((string) $sourceFile);

            if (empty($sourceTranslations)) {
                continue;
            }

            ++$filesProcessed;

            foreach ($targetLangs as $targetLang) {
                $targetPath = "{$moduleLangPath}/{$targetLang}";
                $targetFile = "{$targetPath}/{$fileName}";

                // Create target directory if it doesn't exist
                if (! File::exists($targetPath)) {
                    File::makeDirectory($targetPath, 0o755, true);
                }

                // Load existing target translations
                $targetTranslations = File::exists($targetFile) ? $this->loadTranslations($targetFile) : [];

                // Merge translations
                /** @var array<string, mixed> $sourceTranslations */
                /** @var array<string, mixed> $targetTranslations */
                $mergedTranslations = $this->mergeTranslations($sourceTranslations, $targetTranslations);

                // Save merged translations
                $this->saveTranslations($targetFile, $mergedTranslations);

                $newKeys = count($mergedTranslations) - count($targetTranslations);
                $translationsAdded += (int) $newKeys;
            }
        }

        return [
            'status' => 'completed',
            'files_processed' => $filesProcessed,
            'translations_added' => $translationsAdded,
        ];
    }

    /**
     * Ottiene la lista dei moduli con cartella lang.
     *
     * @param string $modulesPath Percorso dei moduli
     *
     * @return array<string> Lista dei moduli
     */
    private function getModules(string $modulesPath): array
    {
        $modules = [];
        $directories = File::directories($modulesPath);

        foreach ($directories as $directory) {
            $directoryStr = (string) $directory;
            $moduleName = basename($directoryStr);
            if (File::exists("{$directoryStr}/lang")) {
                $modules[] = $moduleName;
            }
        }

        return $modules;
    }

    /**
     * Carica le traduzioni da un file.
     *
     * @param string $filePath Percorso del file
     *
     * @return array<string, mixed> Traduzioni caricate
     */
    private function loadTranslations(string $filePath): array
    {
        if (! File::exists($filePath)) {
            return [];
        }

        try {
            $translations = require $filePath;

            // Ensure we return an array with string keys
            if (is_array($translations)) {
                $result = [];
                foreach ($translations as $key => $value) {
                    if (is_string($key)) {
                        $result[$key] = $value;
                    }
                }

                return $result;
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Filtra un array per avere solo chiavi stringa (aiuta PHPStan).
     *
     * @param array<mixed, mixed> $arr
     *
     * @return array<string, mixed>
     */
    private function filterStringKeyArray(array $arr): array
    {
        $out = [];
        foreach ($arr as $k => $v) {
            if (is_string($k)) {
                $out[$k] = $v;
            }
        }

        return $out;
    }

    /**
     * Unisce le traduzioni sorgente con quelle target.
     *
     * @param array<string, mixed> $source Traduzioni sorgente
     * @param array<string, mixed> $target Traduzioni target
     *
     * @return array<string, mixed> Traduzioni unite
     */
    private function mergeTranslations(array $source, array $target): array
    {
        $merged = $target;

        foreach ($source as $key => $value) {
            if (is_array($value)) {
                /** @var array<string, mixed> $subTarget */
                $subTarget = isset($target[$key]) && is_array($target[$key])
                    ? $this->filterStringKeyArray($target[$key])
                    : [];
                $merged[$key] = $this->mergeTranslations($this->filterStringKeyArray($value), $subTarget);
            } else {
                if (! isset($merged[$key])) {
                    $merged[$key] = $value;
                }
            }
        }

        return $merged;
    }

    /**
     * Salva le traduzioni in un file.
     *
     * @param string               $filePath     Percorso del file
     * @param array<string, mixed> $translations Traduzioni da salvare
     */
    private function saveTranslations(string $filePath, array $translations): void
    {
        $content = "<?php\n\nreturn [\n";
        $content .= $this->arrayToPhp($this->filterStringKeyArray($translations), 1);
        $content .= "];\n";

        File::put($filePath, $content);
    }

    /**
     * Converte un array in formato PHP.
     *
     * @param array<string, mixed> $array  Array da convertire
     * @param int                  $indent Livello di indentazione
     *
     * @return string Codice PHP
     */
    private function arrayToPhp(array $array, int $indent = 0): string
    {
        $content = '';
        $indentStr = str_repeat('    ', $indent);

        foreach ($array as $key => $value) {
            $content .= $indentStr."'".addslashes($key)."' => ";

            if (is_array($value)) {
                $content .= "[\n";
                $content .= $this->arrayToPhp($this->filterStringKeyArray($value), $indent + 1);
                $content .= $indentStr."],\n";
            } else {
                /** @phpstan-ignore-next-line */
                $content .= "'".addslashes((string) $value)."',\n";
            }
        }

        return $content;
    }
}
