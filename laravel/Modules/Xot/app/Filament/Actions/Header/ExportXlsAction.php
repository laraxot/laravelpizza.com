<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Xot\Filament\Actions\Header;

// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Actions\Action;
use Exception;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Export\ExportXlsByCollection;
use Modules\Xot\Actions\Export\GetExportFileNameAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Exports\XlsFieldsExporter;
use Modules\Xot\Filament\Actions\XotBaseAction;
use RuntimeException;
use Webmozart\Assert\Assert;

class ExportXlsAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            // Bottone (vista di default) con etichetta solo per screen reader, come le altre
            // azioni dell'header (Trova esclusi, ...). Prima `iconButton()`: un glifo grigio senza
            // area cliccabile, che non sembrava un comando.
            ->label(fn (): Htmlable|string|null => $this->getTooltip())
            ->hiddenLabel()
            ->tooltip(function (): string {
                $livewire = $this->getLivewire();
                if (! $livewire instanceof ListRecords) {
                    return (string) __('xot::export_xls.tooltip');
                }
                $key = app(GetTransKeyAction::class)->execute($livewire::class).'.actions.export_xls.tooltip';
                $translated = __($key);

                if (\is_string($translated) && $translated !== $key && $translated !== 'export_xls') {
                    return $translated;
                }

                return (string) __('xot::export_xls.tooltip');
            })
            ->icon('xot-files.xls')
            ->action(static function (ListRecords $livewire, ExportXlsAction $action) {
                // Stesso nome file del canale nativo (XotBaseExportAction::fileName).
                $filename = app(GetExportFileNameAction::class)->execute($livewire).'.xlsx';
                $transKey = app(GetTransKeyAction::class)->execute($livewire::class);
                $transKey .= '.fields';
                // Filtri + search + sort: stesse righe nello stesso ordine di
                // `getTableQueryForExport()` usato dal nativo (story Ptv/5.165).
                $query = $livewire->getFilteredSortedTableQuery();
                if ($query === null) {
                    throw new Exception('Query is null');
                }
                // Stesso eager del canale nativo (XotBaseExporter::modifyQuery).
                XlsFieldsExporter::modifyQuery($query);

                $fields = self::resolveXlsFields($livewire);

                if ($fields === []) {
                    // Stesso esito del nativo (CanExportRecords, columnMap vuoto):
                    // avviso e stop. Senza fields CollectionExport farebbe il dump
                    // di tutti gli attributi del model (story Xot/5.162).
                    self::notifyNoColumns();
                    $action->halt();

                    return null;
                }

                return app(ExportXlsByCollection::class)->execute($query->get(), $filename, $transKey, $fields);
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'export_xls';
    }

    /**
     * Chiave stringa = percorso data_get, valore = intestazione esplicita
     * (title rating); chiave intera = percorso tradotto.
     *
     * @return array<int|string, string>
     */
    private static function resolveXlsFields(ListRecords $livewire): array
    {
        $resource = $livewire->getResource();

        if (! method_exists($resource, 'getXlsFields')) {
            // Errore di programmazione (Resource senza il contratto export), non
            // un caso da ispezionare con un dump: story 5.160, AC 3.
            throw new RuntimeException('method getXlsFields does not exist in '.$resource);
        }
        $rawFields = $resource::getXlsFields($livewire->tableFilters ?? []);
        Assert::isArray($rawFields);
        Assert::allString($rawFields);

        return $rawFields;
    }

    private static function notifyNoColumns(): void
    {
        Notification::make()
            ->title(SafeStringCastAction::cast(__('filament-actions::export.notifications.no_columns.title')))
            ->body(SafeStringCastAction::cast(__('filament-actions::export.notifications.no_columns.body')))
            ->danger()
            ->send();
    }
}
