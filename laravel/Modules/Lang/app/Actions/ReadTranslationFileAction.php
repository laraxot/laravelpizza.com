<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Spatie\QueueableAction\QueueableAction;

class ReadTranslationFileAction
{
    use QueueableAction;

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

        /* @phpstan-ignore return.type */
        return $translations;
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
            $content .= $indentStr."'".addslashes($key)."' => ";

            if (is_array($value)) {
                $content .= "[\n";
                /** @phpstan-ignore argument.type */
                $content .= $this->arrayToPhp($value, $indent + 1);
                $content .= $indentStr."],\n";
            } else {
                /** @phpstan-ignore-next-line */
                $content .= "'".addslashes((string) $value)."',\n";
            }
        }

        return $content;
    }
}
