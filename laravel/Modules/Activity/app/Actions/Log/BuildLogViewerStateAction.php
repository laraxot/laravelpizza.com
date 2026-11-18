<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\LogViewerStateData;
use Modules\Activity\Enums\LogLevelEnum;
use Modules\Activity\Exceptions\InvalidLogFileException;
use RuntimeException;
use Safe\Exceptions\SafeExceptionInterface;
use Spatie\QueueableAction\QueueableAction;

use function Safe\filemtime;

/**
 * Stato completo della pagina Log per un render: elenco e albero dei file e, per il file scelto, la coda letta
 * con le voci filtrate. Tiene la pagina sottile: la pagina passa la scelta dell'utente, qui si legge e si filtra.
 *
 * Un file non valido o non leggibile non solleva eccezioni: lo stato ha `error` valorizzato con un messaggio
 * generico (quello dell'eccezione contiene il percorso richiesto e non va mostrato).
 */
class BuildLogViewerStateAction
{
    use QueueableAction;

    /**
     * Finestre di lettura selezionabili, in KB.
     *
     * @var list<int>
     */
    public const array WINDOW_OPTIONS_KB = [128, 256, 512, 1024, 2048, 4096];

    public const int DEFAULT_WINDOW_KB = 256;

    /**
     * @param  string  $file  percorso relativo a storage/logs del file scelto, '' se nessuno
     * @param  string  $window  finestra di lettura in KB (come stringa: arriva dal select della pagina)
     */
    public function execute(string $file, string $level = '', string $search = '', string $window = '256'): LogViewerStateData
    {
        $files = app(ListLogFilesAction::class)->execute();

        $entries = [];
        $total = 0;
        $tail = null;
        $modifiedAt = null;
        $error = null;

        if ($file !== '') {
            try {
                $resolved = app(ResolveLogFilePathAction::class)->execute($file);
                $tail = app(ReadLogTailAction::class)->execute($resolved->absolutePath, $this->windowBytes($window));
                $filtered = app(FilterLogEntriesAction::class)->execute(
                    app(ParseLogEntriesAction::class)->execute($tail->content),
                    $this->validLevel($level),
                    $search,
                    FilterLogEntriesAction::DEFAULT_LIMIT,
                );

                $entries = $filtered->entries;
                $total = $filtered->total;
                // Safe\filemtime() lancia un'eccezione se il file sparisce: gestita sotto.
                $modifiedAt = filemtime($resolved->absolutePath);
            } catch (InvalidLogFileException|RuntimeException|SafeExceptionInterface) {
                $entries = [];
                $total = 0;
                $tail = null;
                // $modifiedAt resta null: filemtime() e' l'ultima istruzione del try e lancia prima di assegnare.
                $message = __('activity::log_viewer.messages.file_unavailable');
                $error = is_string($message) ? $message : null;
            }
        }

        return new LogViewerStateData(
            files: $files,
            tree: app(BuildLogFileTreeAction::class)->execute($files),
            levels: LogLevelEnum::cases(),
            windows: self::WINDOW_OPTIONS_KB,
            entries: $entries,
            total: $total,
            tail: $tail,
            modifiedAt: $modifiedAt,
            error: $error,
        );
    }

    private function windowBytes(string $window): int
    {
        $kb = (int) $window;
        if (! in_array($kb, self::WINDOW_OPTIONS_KB, true)) {
            $kb = self::DEFAULT_WINDOW_KB;
        }

        return $kb * 1024;
    }

    private function validLevel(string $level): string
    {
        $levelEnum = LogLevelEnum::tryFrom(mb_strtoupper(trim($level)));

        return $levelEnum instanceof LogLevelEnum ? $levelEnum->value : '';
    }
}
