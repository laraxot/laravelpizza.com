<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Facades\File;

use function Safe\exec;
use function Safe\file_put_contents;
use function Safe\tempnam;
use function Safe\unlink;

use Spatie\QueueableAction\QueueableAction;

class WriteTranslationFileAction
{
    use QueueableAction;

    /**
     * Scrive il contenuto in un file di traduzione con backup automatico.
     *
     * @param string               $filePath     Percorso del file di traduzione
     * @param array<string, mixed> $translations Traduzioni da scrivere
     *
     * @return bool True se il file è stato scritto con successo
     */
    public function execute(string $filePath, array $translations): bool
    {
        // Crea backup del file esistente
        $this->createBackup($filePath);

        // Converte le traduzioni in formato PHP
        $readAction = app(ReadTranslationFileAction::class);
        $phpContent = $readAction->toPhp($translations);

        // Verifica la sintassi PHP prima di scrivere
        $this->validatePhpSyntax($phpContent);

        // Scrivi il file
        $result = File::put($filePath, $phpContent);

        if (false === $result) {
            throw new \Exception("Impossibile scrivere il file: {$filePath}");
        }

        // Pulisci la cache delle traduzioni
        $this->clearTranslationCache();

        return true;
    }

    /**
     * Crea un backup del file di traduzione.
     *
     * @param string $filePath Percorso del file
     */
    private function createBackup(string $filePath): void
    {
        if (! file_exists($filePath)) {
            return;
        }

        $backupDir = storage_path('app/backups/translations');
        $backupPath = $backupDir.'/'.date('Y-m-d_H-i-s').'_'.basename($filePath);

        // Crea la directory di backup se non esiste
        if (! File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0o755, true);
        }

        // Copia il file
        File::copy($filePath, $backupPath);
    }

    /**
     * Valida la sintassi PHP del contenuto.
     *
     * @param string $phpContent Contenuto PHP da validare
     *
     * @throws \Exception Se la sintassi PHP non è valida
     */
    private function validatePhpSyntax(string $phpContent): void
    {
        // Crea un file temporaneo per la validazione
        $tempFile = tempnam(storage_path('framework/cache'), 'translation_');
        file_put_contents($tempFile, $phpContent);

        // Esegue php -l per validare la sintassi
<<<<<<< HEAD
        /** @var array<int, string> $output */
        $output = [];
=======
        $rawOutput = [];
>>>>>>> 40b96bcd6 (.)
        $returnCode = 0;
        exec("php -l {$tempFile} 2>&1", $rawOutput, $returnCode);
        $output = is_array($rawOutput) ? $rawOutput : [];

        unlink($tempFile);

        if (0 !== $returnCode) {
<<<<<<< HEAD
            $errorOutput = \is_array($output) ? $output : [];
            $errorLines = array_map(
                static fn (mixed $line): string => (string) $line,
                $errorOutput,
            );
            $error = implode("\n", $errorLines);
=======
            $lines = [];
            foreach ($output as $line) {
                if (is_string($line)) {
                    $lines[] = $line;
                }
            }
            $error = implode("\n", $lines);
>>>>>>> 40b96bcd6 (.)
            throw new \Exception("Sintassi PHP non valida: {$error}");
        }
    }

    /**
     * Pulisce la cache delle traduzioni.
     */
    private function clearTranslationCache(): void
    {
        // Pulisce la cache di Laravel
        if (app()->bound('cache')) {
            app('cache')->flush();
        }

        // Pulisce la cache delle traduzioni
        if (app()->bound('translation.loader')) {
            $loader = app('translation.loader');
            if (method_exists($loader, 'flush')) {
                $loader->flush();
            }
        }
    }
}
