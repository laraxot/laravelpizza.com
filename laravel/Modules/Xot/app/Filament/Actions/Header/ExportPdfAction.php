<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions\Header;

// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Actions\Action;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Modules\Xot\Actions\Pdf\DownloadPdfByViewAction;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Webmozart\Assert\Assert;

class ExportPdfAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            ->label('')
            ->tooltip(__('xot::actions.export_pdf.tooltip'))
            ->icon('ui-files.pdf')
            ->action(static function (ListRecords $livewire) {
                $filename =
                    class_basename($livewire).
                    '-'.
                    collect($livewire->tableFilters)->flatten()->implode('-').
                    '.pdf';
                $query = $livewire->getFilteredTableQuery();
                if (null === $query) {
                    throw new \Exception('Query is null');
                }
                $rows = $query->get();

                $resource = $livewire->getResource();
                $modelClass = $resource::getModel();
                Assert::string($modelClass);
                $view = app(GetViewByModelClassAction::class)->execute($modelClass, '.index');
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
