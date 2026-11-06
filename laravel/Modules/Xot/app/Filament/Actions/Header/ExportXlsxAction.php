<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions\Header;

use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Exports\XlsFieldsExporter;
use Modules\Xot\Filament\Actions\XotBaseExportAction;

/**
 * Export xlsx generico, Filament way: `ExportAction` nativa (queue, notifica,
 * storico in `exports`) con le colonne prese dal `getXlsFields()` del Resource
 * della pagina, come `ExportXlsAction`. Stesso file dei due canali (story Ptv/5.165).
 *
 * Uso in qualunque `ListRecords` il cui Resource espone `getXlsFields()`:
 *
 *     'export_xlsx' => ExportXlsxAction::make('export_xlsx'),
 *
 * Exporter proprio del modulo (deve estendere `XotBaseExporter`):
 *
 *     ExportXlsxAction::make('export_xlsx')->exporter(MioExporter::class)
 *
 * Tooltip da `{transKey pagina}.actions.export_xlsx.tooltip`.
 */
class ExportXlsxAction extends XotBaseExportAction
{
    public static function getDefaultName(): ?string
    {
        return 'export_xlsx';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter(XlsFieldsExporter::class)
            // Tutte le colonne di getXlsFields, sempre: il modal di scelta
            // romperebbe la parita' con export_xls.
            ->columnMapping(false)
            ->formats([
                ExportFormat::Xlsx,
            ])
            // Senza columnMap e senza options form il modal sarebbe vuoto
            // (solo heading + "Esporta"): click e parte.
            ->modal(false)
            ->label('')
            ->iconButton()
            ->color('success')
            ->icon('xot-files.xlsx')
            ->tooltip(function (): string {
                $livewire = $this->getLivewire();
                if (! $livewire instanceof ListRecords) {
                    return (string) __('xot::export_xlsx.tooltip');
                }
                $key = app(GetTransKeyAction::class)->execute($livewire::class).'.actions.export_xlsx.tooltip';
                $translated = __($key);

                if (\is_string($translated) && $translated !== $key && $translated !== 'export_xlsx') {
                    return $translated;
                }

                return (string) __('xot::export_xlsx.tooltip');
            });
    }
}
