<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Activity\Actions\Log\AuthorizeLogAccessAction;
use Modules\Activity\Actions\Log\BuildLogViewerStateAction;
use Modules\Activity\Actions\Log\ListLogFilesAction;
use Modules\Activity\Actions\Log\ResolveLogFilePathAction;
use Modules\Activity\Datas\LogFileData;
use Modules\Activity\Datas\LogViewerStateData;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * Pagina per consultare dal pannello i file di log in storage/logs (comprese le sottocartelle), utile dove non
 * c'e' accesso SSH/FTP.
 *
 * - sola lettura: nessuna modifica o cancellazione di file;
 * - albero di cartelle a sinistra, voci del file scelto a destra;
 * - legge solo la CODA del file scelto (finestra selezionabile), mai il file intero;
 * - ricerca e filtro per livello valgono sulla parte letta; il download restituisce il file completo;
 * - accesso limitato ai super-admin o a chi ha il permesso `log.viewAny` ({@see AuthorizeLogAccessAction}).
 *
 * La logica sta nelle Action (`app/Actions/Log`): la pagina tiene solo lo stato della scelta dell'utente.
 * Tutti i percorsi passano da {@see ResolveLogFilePathAction}, che impedisce di uscire da storage/logs.
 * Il download e' la pagina Folio `resources/views/pages/api/log-download.blade.php` (nessun Controller).
 */
class LogViewer extends XotBasePage
{
    /** Indirizzo della pagina Folio del download. */
    public const string DOWNLOAD_PATH = '/api/log-download';

    protected string $view = 'activity::filament.pages.log-viewer';

    /** Percorso relativo a storage/logs del file scelto. */
    public string $file = '';

    public string $level = '';

    public string $search = '';

    /** Stringa e non int: Livewire riceve i valori del select come stringhe. */
    public string $window = '256';

    /**
     * Percorsi (relativi a storage/logs) delle cartelle aperte nell'albero dei file.
     *
     * Lo stato e' tenuto qui, lato server, e non nel browser: cosi' non si perde quando la pagina si
     * aggiorna (per esempio mentre si scrive nella ricerca) ed e' verificabile nei test.
     *
     * @var list<string>
     */
    public array $expanded = [];

    public static function canAccess(): bool
    {
        return app(AuthorizeLogAccessAction::class)->execute(Filament::auth()->user());
    }

    public function mount(): void
    {
        $files = app(ListLogFilesAction::class)->execute();

        if ($this->file === '') {
            $this->file = $this->defaultFile($files);
        }

        $this->expanded = $this->defaultExpanded($files);
    }

    /**
     * Sceglie il file da leggere (click su un file dell'albero).
     *
     * Il valore viene comunque ricontrollato da {@see ResolveLogFilePathAction} a ogni lettura.
     */
    public function selectFile(string $path): void
    {
        $this->file = $path;
    }

    /**
     * Apre o chiude una cartella dell'albero.
     */
    public function toggleFolder(string $path): void
    {
        if (in_array($path, $this->expanded, true)) {
            $this->expanded = array_values(array_filter(
                $this->expanded,
                static fn (string $open): bool => $open !== $path,
            ));

            return;
        }

        $this->expanded[] = $path;
    }

    public function getDownloadUrl(): string
    {
        return url(self::DOWNLOAD_PATH).'?'.http_build_query(['file' => $this->file]);
    }

    /**
     * Stato completo della pagina (elenco e albero dei file + voci del file scelto), calcolato una volta per render.
     */
    public function getLogState(): LogViewerStateData
    {
        return app(BuildLogViewerStateAction::class)->execute($this->file, $this->level, $this->search, $this->window);
    }

    /**
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'refresh' => Action::make('refresh')
<<<<<<< .merge_file_QL2KNT
                ->label((string) __('activity::log_viewer.actions.refresh.label'))
=======
                ->label($this->translation('activity::log_viewer.actions.refresh.label'))
>>>>>>> .merge_file_FLeT0N
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(static fn (): null => null),
            'download' => Action::make('download')
<<<<<<< .merge_file_QL2KNT
                ->label((string) __('activity::log_viewer.actions.download.label'))
=======
                ->label($this->translation('activity::log_viewer.actions.download.label'))
>>>>>>> .merge_file_FLeT0N
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => $this->getDownloadUrl())
                ->disabled(fn (): bool => $this->file === ''),
        ];
    }

    /**
     * Preferisce `laravel.log`; altrimenti il file modificato piu' di recente (l'elenco e' gia' ordinato).
     *
     * @param  list<LogFileData>  $files
     */
    private function defaultFile(array $files): string
    {
        foreach ($files as $file) {
            if ($file->path === 'laravel.log') {
                return $file->path;
            }
        }

        return $files[0]->path ?? '';
    }

<<<<<<< .merge_file_QL2KNT
=======
    private function translation(string $key): string
    {
        $translation = __($key);

        return is_string($translation) ? $translation : $key;
    }

>>>>>>> .merge_file_FLeT0N
    /**
     * Cartelle aperte all'inizio: quelle di primo livello e tutte quelle che contengono il file scelto,
     * cosi' il file selezionato e' sempre visibile nell'albero.
     *
     * @param  list<LogFileData>  $files
     * @return list<string>
     */
    private function defaultExpanded(array $files): array
    {
        $expanded = [];

        foreach ($files as $file) {
            if ($file->directory !== '') {
                $expanded[] = explode('/', $file->directory)[0];
            }

            if ($file->path === $this->file) {
                array_push($expanded, ...$file->ancestorFolders());
            }
        }

        return array_values(array_unique($expanded));
    }
}
