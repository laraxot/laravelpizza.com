<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions\Table;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Export\PdfByModelAction;

class PdfAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            ->tooltip('pdf')
            ->openUrlInNewTab()
            // ->icon('heroicon-o-cloud-arrow-down')
            // ->icon('fas-file-excel')
            ->icon('heroicon-o-document-arrow-down')
            ->action(fn (Model $record) => app(PdfByModelAction::class)->execute(model: $record));
    }
}
