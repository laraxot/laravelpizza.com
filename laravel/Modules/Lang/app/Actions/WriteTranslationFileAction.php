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
     * @throws \Exception Se il file non può essere scritto
     *
     * @return bool True se il file è stato scritto con successo
     */
    public function execute(string $filePath, array $translations): bool
    {
        // Crea backup del file esistente
        // @var mixed createBackup($filePath;

        // Converte le traduzioni in formato PHP
        $readAction = app(ReadTranslationFileAction::class);
        $phpContent = $readAction->toPhp($translations);

        // Verifica la sintassi PHP prima di scrivere
        // @var mixed validatePhpSyntax($phpContent;

        // Scrivi il file
        $result = File::put($filePath, $phpContent);

        if (false === $result) {
            throw new \Exception("Impossibile scrivere il file: {$filePath}");
        }

        // Pulisci la cache delle traduzioni
        // @var mixed clearTranslationCache(;

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
        $tempFile = tempnam(sys_get_temp_dir(), 'translation_');
        file_put_contents($tempFile, $phpContent);

        // Esegue php -l per validare la sintassi
        $output = [];
        $returnCode = 0;
        exec("php -l {$tempFile} 2>&1", $output, $returnCode);

        // Rimuove il file temporaneo
        unlink($tempFile);

        if (0 !== $returnCode) {
            $error = implode("\n", $output ?? []);
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
            /* @phpstan-ignore method.notFound */
            app('translation.loader')->flush();
        }
    }
}
