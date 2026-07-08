<?php

declare(strict_types=1);

/**
 * Script per sincronizzare le traduzioni dei temi One e Two
 * Copia le traduzioni italiane in inglese e tedesco per i temi
 */

require_once __DIR__ . '/../../laravel/vendor/autoload.php';

use Illuminate\Support\Arr;

class ThemeTranslationSynchronizer
{
    private string $basePath;
    private array $themes = ['One', 'Two'];
    private array $targetLanguages = ['en', 'de'];

    public function __construct()
    {
        $this->basePath = __DIR__ . '/../../laravel/Themes';
    }

    /**
     * Sincronizza le traduzioni per tutti i temi
     */
    public function syncAllThemes(): void
    {
        echo "🚀 Iniziando sincronizzazione traduzioni temi...\n\n";

        foreach ($this->themes as $theme) {
            $this->syncTheme($theme);
        }

        echo "\n✅ Sincronizzazione traduzioni temi completata!\n";
    }

    /**
     * Sincronizza le traduzioni per un tema specifico
     */
    private function syncTheme(string $theme): void
    {
        $themePath = $this->basePath . '/' . $theme;
        $langPath = $themePath . '/lang';

        echo "📁 Tema: {$theme}\n";

        // Verifica se il tema esiste
        if (!is_dir($themePath)) {
            echo "   ⚠️  Tema {$theme} non trovato, saltando...\n\n";
            return;
        }

        // Crea la cartella lang se non esiste
        if (!is_dir($langPath)) {
            mkdir($langPath, 0755, true);
            echo "   📁 Creata cartella lang per il tema {$theme}\n";
        }

        // Verifica se esistono traduzioni italiane
        $italianPath = $langPath . '/it';
        if (!is_dir($italianPath)) {
            echo "   ⚠️  Nessuna traduzione italiana trovata per il tema {$theme}, saltando...\n\n";
            return;
        }

        $italianFiles = $this->getTranslationFiles($italianPath);
        if (empty($italianFiles)) {
            echo "   ⚠️  Nessun file di traduzione italiano trovato per il tema {$theme}, saltando...\n\n";
            return;
        }

        echo "   📄 File di traduzione italiani trovati: " . count($italianFiles) . "\n";

        $totalKeys = 0;
        $totalFiles = 0;

        // Sincronizza per ogni lingua target
        foreach ($this->targetLanguages as $targetLang) {
            $targetPath = $langPath . '/' . $targetLang;
            
            // Crea la cartella della lingua target se non esiste
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0755, true);
                echo "   📁 Creata cartella {$targetLang} per il tema {$theme}\n";
            }

            $langKeys = 0;
            $langFiles = 0;

            foreach ($italianFiles as $file) {
                $result = $this->syncTranslationFile($italianPath, $targetPath, $file);
                if ($result['synced']) {
                    $langKeys += $result['keys'];
                    $langFiles++;
                }
            }

            if ($langKeys > 0) {
                echo "   ✅ {$targetLang}: {$langKeys} chiavi sincronizzate in {$langFiles} file\n";
                $totalKeys += $langKeys;
                $totalFiles += $langFiles;
            } else {
                echo "   ℹ️  {$targetLang}: nessuna nuova chiave da sincronizzare\n";
            }
        }

        if ($totalKeys > 0) {
            echo "   📊 Totale tema {$theme}: {$totalKeys} chiavi sincronizzate in {$totalFiles} file\n";
        }

        echo "\n";
    }

    /**
     * Ottiene la lista dei file di traduzione in una directory
     */
    private function getTranslationFiles(string $path): array
    {
        $files = [];
        if (is_dir($path)) {
            $items = scandir($path);
            foreach ($items as $item) {
                if ($item !== '.' && $item !== '..' && is_file($path . '/' . $item)) {
                    $extension = pathinfo($item, PATHINFO_EXTENSION);
                    if ($extension === 'php') {
                        $files[] = $item;
                    }
                }
            }
        }
        return $files;
    }

    /**
     * Sincronizza un singolo file di traduzione
     */
    private function syncTranslationFile(string $sourcePath, string $targetPath, string $filename): array
    {
        $sourceFile = $sourcePath . '/' . $filename;
        $targetFile = $targetPath . '/' . $filename;

        // Carica le traduzioni italiane
        $italianTranslations = $this->loadTranslations($sourceFile);
        if (empty($italianTranslations)) {
            return ['synced' => false, 'keys' => 0];
        }

        // Carica le traduzioni target esistenti
        $targetTranslations = [];
        if (file_exists($targetFile)) {
            $targetTranslations = $this->loadTranslations($targetFile);
        }

        // Unisci le traduzioni
        $mergedTranslations = $this->mergeTranslations($italianTranslations, $targetTranslations);

        // Salva le traduzioni unite
        $this->saveTranslations($targetFile, $mergedTranslations);

        // Conta le nuove chiavi aggiunte
        $newKeys = $this->countNewKeys($italianTranslations, $targetTranslations);

        return [
            'synced' => true,
            'keys' => $newKeys
        ];
    }

    /**
     * Carica le traduzioni da un file
     */
    private function loadTranslations(string $filepath): array
    {
        if (!file_exists($filepath)) {
            return [];
        }

        try {
            $translations = require $filepath;
            return is_array($translations) ? $translations : [];
        } catch (Throwable $e) {
            echo "   ⚠️  Errore nel caricamento del file {$filepath}: " . $e->getMessage() . "\n";
            return [];
        }
    }

    /**
     * Unisce le traduzioni mantenendo quelle esistenti
     */
    private function mergeTranslations(array $source, array $target): array
    {
        $merged = $target;

        foreach ($source as $key => $value) {
            if (is_array($value)) {
                if (!isset($merged[$key]) || !is_array($merged[$key])) {
                    $merged[$key] = [];
                }
                $merged[$key] = $this->mergeTranslations($value, $merged[$key]);
            } else {
                if (!isset($merged[$key])) {
                    $merged[$key] = $value;
                }
            }
        }

        return $merged;
    }

    /**
     * Salva le traduzioni in un file
     */
    private function saveTranslations(string $filepath, array $translations): void
    {
        $content = "<?php\n\n";
        $content .= "declare(strict_types=1);\n\n";
        $content .= "return " . $this->arrayToString($translations) . ";\n";

        file_put_contents($filepath, $content);
    }

    /**
     * Converte un array in stringa PHP
     */
    private function arrayToString(array $array, int $indent = 0): string
    {
        $indentStr = str_repeat('    ', $indent);
        $result = "[\n";

        foreach ($array as $key => $value) {
            $result .= $indentStr . "    ";
            
            if (is_string($key)) {
                $result .= "'" . addslashes($key) . "' => ";
            } else {
                $result .= $key . " => ";
            }

            if (is_array($value)) {
                $result .= $this->arrayToString($value, $indent + 1);
            } elseif (is_string($value)) {
                $result .= "'" . addslashes($value) . "'";
            } elseif (is_bool($value)) {
                $result .= $value ? 'true' : 'false';
            } elseif (is_null($value)) {
                $result .= 'null';
            } else {
                $result .= $value;
            }

            $result .= ",\n";
        }

        $result .= $indentStr . "]";
        return $result;
    }

    /**
     * Conta le nuove chiavi aggiunte
     */
    private function countNewKeys(array $source, array $target): int
    {
        $count = 0;
        
        foreach ($source as $key => $value) {
            if (is_array($value)) {
                if (!isset($target[$key]) || !is_array($target[$key])) {
                    $count++;
                } else {
                    $count += $this->countNewKeys($value, $target[$key]);
                }
            } else {
                if (!isset($target[$key])) {
                    $count++;
                }
            }
        }

        return $count;
    }
}

// Esegui la sincronizzazione
try {
    $synchronizer = new ThemeTranslationSynchronizer();
    $synchronizer->syncAllThemes();
} catch (Throwable $e) {
    echo "❌ Errore durante la sincronizzazione: " . $e->getMessage() . "\n";
    exit(1);
} 