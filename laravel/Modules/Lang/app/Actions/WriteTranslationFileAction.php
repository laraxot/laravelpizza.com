<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

use function Safe\date;
use function Safe\exec;
use function Safe\file_put_contents;
use function Safe\tempnam;
use function Safe\unlink;

<<<<<<< .merge_file_AYWuuz
/**
 * @see docs/contracts/write-translation-file-action.md
 *
 * @contract docs/contracts/write-translation-file-action.md
 */
=======
>>>>>>> .merge_file_rAwdUL
class WriteTranslationFileAction
{
    use QueueableAction;

    /**
     * Scrive il contenuto in un file di traduzione con backup automatico.
     *
     * @param  string  $filePath  Percorso del file di traduzione
     * @param  array<string, mixed>  $translations  Traduzioni da scrivere
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

        // Una lingua nuova e' una cartella nuova: `lang/de/` non esiste finche'
        // nessuno ha scritto la prima traduzione tedesca. Senza questa riga il
        // primo file di ogni locale nuovo falliva con
        // «Failed to open stream: No such file or directory»
        // (base_quaeris_fila5#234).
        File::ensureDirectoryExists(dirname($filePath));

        if (! $this->putTranslationFile($filePath, $phpContent)) {
            throw new \Exception("Impossibile scrivere il file: {$filePath}");
        }

        // Pulisci la cache delle traduzioni
        $this->clearTranslationCache();

        return true;
    }

    /**
     * Scrive il file di traduzione, riportando l'esito come booleano.
     *
     * ## Perche' e' un metodo a parte, e protected
     *
     * E' l'unico punto in cui questa action tocca il file di destinazione.
     * Isolarlo rende verificabile il ramo «la scrittura non riesce» —
     * `execute()` deve lanciare — senza sostituire la facade File per l'intero
     * test, cioe' senza spegnere la scrittura anche al resto del framework.
     *
     * Non e' un'astrazione inventata per i test: le fixture del modulo la
     * sovrascrivevano **gia'**
     * (`Modules\Lang\Tests\Fixtures\WriteTranslationFileActionFailStub`), ma qui
     * non esisteva. L'override era inerte, `execute()` riusciva, e il test che
     * attendeva l'eccezione falliva con «Exception not thrown» — che sembra un
     * difetto del codice e invece era una fixture morta
     * (base_quaeris_fila5#234).
     *
     * ## Perche' non lascia passare l'errore
     *
     * Il contratto e' «ha scritto, si'/no», e un chiamante che riceve `false`
     * sa cosa fare: `execute()` lancia con il percorso dentro il messaggio.
     * Una cartella mancante e' quindi `false`, non un'eccezione: la cartella la
     * crea `execute()`, un passo prima. In ambiente di test gli warning di PHP
     * diventano `ErrorException`, quindi un `File::put()` che fuori dai test
     * restituirebbe `false` qui lancerebbe: il `catch` serve a rendere lo
     * stesso esito nei due ambienti.
     */
    protected function putTranslationFile(string $filePath, string $phpContent): bool
    {
        if (! File::isDirectory(dirname($filePath))) {
            return false;
        }

        try {
            return File::put($filePath, $phpContent) !== false;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * Scrive il contenuto nel file temporaneo usato per il controllo sintattico.
     *
     * Separato per la stessa ragione di {@see putTranslationFile()}: e' l'altra
     * scrittura su disco di questa action, e
     * `WriteTranslationFileActionWriteFailStub` la sovrascrive per verificare
     * che `execute()` lanci quando il file temporaneo non si scrive.
     *
     * Il tipo di ritorno comprende `false` perche' e' quello che la fixture
     * restituisce; la versione reale usa `Safe\file_put_contents`, che in caso
     * di errore lancia invece di restituire `false`.
     */
    protected function writeLangTempContents(string $tempFile, string $phpContent): int|false
    {
        return file_put_contents($tempFile, $phpContent);
    }

    /**
     * Crea un backup del file di traduzione.
     *
     * @param  string  $filePath  Percorso del file
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
     * @param  string  $phpContent  Contenuto PHP da validare
     *
     * @throws \Exception Se la sintassi PHP non è valida
     */
    private function validatePhpSyntax(string $phpContent): void
    {
        // Crea un file temporaneo per la validazione
        $tempFile = tempnam(storage_path('framework/cache'), 'translation_');

        if ($this->writeLangTempContents($tempFile, $phpContent) === false) {
            unlink($tempFile);

            throw new \Exception("Impossibile scrivere il file temporaneo di validazione: {$tempFile}");
        }

        // Esegue php -l per validare la sintassi
        $rawOutput = [];
        $returnCode = 0;
        exec("php -l {$tempFile} 2>&1", $rawOutput, $returnCode);
        $output = is_array($rawOutput) ? $rawOutput : [];

        unlink($tempFile);

        if ($returnCode !== 0) {
            $lines = [];
            foreach ($output as $line) {
                if (is_string($line)) {
                    $lines[] = $line;
                }
            }
            $error = implode("\n", $lines);
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
            /** @var object $cache */
            $cache = app('cache');
            if (method_exists($cache, 'flush')) {
                $cache->flush();
            }
        }

        // Pulisce la cache delle traduzioni
        if (app()->bound('translation.loader')) {
            /** @var object $loader */
            $loader = app('translation.loader');
            if (method_exists($loader, 'flush')) {
                $loader->flush();
            }
        }
    }
}
