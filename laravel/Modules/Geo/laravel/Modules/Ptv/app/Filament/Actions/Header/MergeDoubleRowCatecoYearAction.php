<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Header;

use Filament\Actions\Action;
// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Arr;
use Modules\Ptv\Actions\MergeDoubleRowCatecoByModelClassYearAction;

class MergeDoubleRowCatecoYearAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'merge_double_row_cateco_year';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip(__('ptv::scheda.actions.merge_double_row_cateco_year'))
            ->icon('fas-code-merge')
            ->action(function ($livewire, $record, $action): void {
                if (! ($livewire instanceof ListRecords)) {
                    return;
                }

                $resource = $livewire->getResource();
                $modelClass = $resource::getModel();

                if (! is_string($modelClass)) {
                    return;
                }

                $tableFilters = is_array($livewire->tableFilters) ? $livewire->tableFilters : [];
                $year = Arr::get($tableFilters, 'anno.value');
                // 2023

                $fieldname = 'anno';
                $yearInt = is_numeric($year) ? (int) $year : 0;
                app(MergeDoubleRowCatecoByModelClassYearAction::class)->execute($modelClass, $fieldname, $yearInt);
                Notification::make()
                    ->title('Successfully')
                    ->success()
                    ->send();
            });
    }
}
