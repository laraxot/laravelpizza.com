<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Xot\Filament\Actions\Header;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Actions\Pdf\DownloadPdfByViewAction;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Webmozart\Assert\Assert;

/**
 * Export PDF da lista: bottone con icona `xot-files.pdf` ed etichetta sr-only (tooltip), view
 * `{modulo}::{model}.index.pdf` con RichEditor via `{!! $rating->getTxtHtml() !!}`.
 */
class ExportPdfAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this
            // Bottone (vista di default) con etichetta solo per screen reader, come le altre
            // azioni dell'header (Trova esclusi, ...). Prima `iconButton()`: un glifo grigio senza
            // area cliccabile, che non sembrava un comando.
            ->label(fn (): Htmlable|string|null => $this->getTooltip())
            ->hiddenLabel()
            // ->color('danger'): non usato, il rosso segnala un'azione distruttiva; resta il
            // primario come i bottoni accanto.
            ->icon('xot-files.pdf')
            ->tooltip(function (): string {
                $livewire = $this->getLivewire();
                if (! $livewire instanceof ListRecords) {
                    return (string) __('xot::export_pdf.tooltip');
                }
                $key = app(GetTransKeyAction::class)->execute($livewire::class).'.actions.export_pdf.tooltip';
                $translated = __($key);

                if (\is_string($translated) && $translated !== $key && $translated !== 'export_pdf') {
                    return $translated;
                }

                return (string) __('xot::export_pdf.tooltip');
            })
            ->action(static function (ListRecords $livewire) {
                $filename =
                    class_basename($livewire).
                    '-'.
                    collect($livewire->tableFilters)->flatten()->implode('-').
                    '.pdf';
                $query = $livewire->getFilteredTableQuery();
                if ($query === null) {
                    throw new \Exception('Query is null');
                }
                $rows = $query->get();

                $resource = $livewire->getResource();
                $modelClass = $resource::getModel();
                Assert::string($modelClass);
                $view = app(GetViewByModelClassAction::class)->execute($modelClass, '.index.pdf');

                $viewParams = [
                    'title' => $livewire->getTitle(),
                    'rows' => $rows,
                ];

                return app(DownloadPdfByViewAction::class)->execute($view, $viewParams, $filename);
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'export_pdf';
    }
}
