<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class ReadTranslationFileAction
{
    use QueueableAction;

    /**
     * @param array<mixed, mixed> $value
     *
     * @return array<string, mixed>
     */
    private function assertStringKeyedArray(array $value): array
    {
        Assert::allString(array_keys($value), 'Translation array must have string keys.');

        /* @var array<string, mixed> $value */
        return $value;
    }

    /**
     * Legge il contenuto di un file di traduzione.
     *
     * @param string $filePath Percorso del file di traduzione
     *
     * @throws \Exception Se il file non esiste o non è leggibile
     *
     * @return array<string, mixed> Contenuto del file di traduzione
     */
    public function execute(string $filePath): array
    {
        if (! file_exists($filePath)) {
            throw new \Exception("File di traduzione non trovato: {$filePath}");
        }

        if (! is_readable($filePath)) {
            throw new \Exception("File di traduzione non leggibile: {$filePath}");
        }

        // Carica il file di traduzione
        $translations = require $filePath;

        if (! is_array($translations)) {
            throw new \Exception("File di traduzione non valido: {$filePath}");
        }

        return $this->assertStringKeyedArray($translations);
    }

    /**
     * Converte un array di traduzioni in formato PHP.
     *
     * @param array<string, mixed> $translations Traduzioni da convertire
     *
     * @return string Codice PHP del file di traduzione
     */
    public function toPhp(array $translations): string
    {
        $content = "<?php\n\nreturn [\n";
        $content .= $this->arrayToPhp($translations, 1);
        $content .= "];\n";

        return $content;
    }

    /**
     * Converte un array in formato PHP con indentazione.
     *
     * @param array<string, mixed> $array  Array da convertire
     * @param int                  $indent Livello di indentazione
     *
     * @return string Codice PHP dell'array
     */
    private function arrayToPhp(array $array, int $indent = 0): string
    {
        $content = '';
        $indentStr = str_repeat('    ', $indent);

        foreach ($array as $key => $value) {
            $content .= $indentStr."'".addslashes((string) $key)."' => ";

            if (is_array($value)) {
                $value = $this->assertStringKeyedArray($value);
                $content .= "[\n";
                $content .= $this->arrayToPhp($value, $indent + 1);
                $content .= $indentStr."],\n";
            } else {
                $content .= "'".addslashes((string) $value)."',\n";
            }
        }

        return $content;
    }
}
