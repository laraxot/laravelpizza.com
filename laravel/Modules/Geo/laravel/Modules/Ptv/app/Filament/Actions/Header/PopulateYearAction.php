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
use Modules\Ptv\Actions\PopulateByYearAction;

class PopulateYearAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'populate_year';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip(__('ptv::scheda.actions.'.$this->getDefaultName().'.label'))
            ->icon('fas-fill')
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
                $fieldname = 'anno';
                if ($year == null) {
                    $year = Arr::get($tableFilters, 'year.value');
                    $fieldname = 'year';
                }
                if ($year == null) {
                    $year = Arr::get($tableFilters, 'anno/valutatore.anno');
                    $fieldname = 'anno';
                }
                if ($year == null) {
                    $year = Arr::get($tableFilters, 'anno_valutatore.anno');
                    $fieldname = 'anno';
                }

                $yearInt = is_numeric($year) ? (int) $year : 0;

                app(PopulateByYearAction::class)->execute($modelClass, $fieldname, $yearInt);
                Notification::make()
                    ->title('Successfully')
                    ->success()
                    ->send();
            });
        $this->visible(function ($livewire): bool {
            if (! ($livewire instanceof ListRecords)) {
                return false;
            }

            $resource = $livewire->getResource();
            $canCreate = $resource::can('create');

            return is_bool($canCreate) ? $canCreate : false;
        });
    }
}
