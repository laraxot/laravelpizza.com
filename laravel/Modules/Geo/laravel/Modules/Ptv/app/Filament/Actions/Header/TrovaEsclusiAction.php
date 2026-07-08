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
use Modules\Ptv\Actions\Scheda\TrovaEsclusiByModelClassYearAction;
use Modules\Ptv\Models\Contracts\SchedaContract;

class TrovaEsclusiAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'trova_esclusi';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip(__('ptv::scheda.actions.trova_esclusi.label'))
            ->icon('fas-skull')
            ->visible(function ($livewire): bool {
                if (! ($livewire instanceof ListRecords)) {
                    return false;
                }

                $resource = $livewire->getResource();
                $user = auth()->user();

                return $user?->isSuperAdmin() ?? false;
                /*
                $canCreate = $resource::can('create');

                return is_bool($canCreate) ? $canCreate : false;
                */
            })
            ->action(function ($livewire, $record, $action): void {
                if (! ($livewire instanceof ListRecords)) {
                    return;
                }

                $resource = $livewire->getResource();
                $modelClass = $resource::getModel();

                if (! is_string($modelClass) || ! is_a($modelClass, SchedaContract::class, true)) {
                    return;
                }

                $tableFilters = is_array($livewire->tableFilters) ? $livewire->tableFilters : [];
                $year = Arr::get($tableFilters, 'anno.value');

                // 2023
                $fieldname = 'anno';
                if ($year == null) {
                    $year = Arr::get($tableFilters, 'year.value');
                    // 2023
                    $fieldname = 'year';
                }

                if ($year == null) {
                    $year = Arr::get($tableFilters, 'anno_valutatore.anno');
                    // 2023
                    $fieldname = 'anno';
                }

                $yearInt = is_numeric($year) ? (int) $year : 0;

                app(TrovaEsclusiByModelClassYearAction::class)->execute($modelClass, $fieldname, $yearInt);

                Notification::make()
                    ->title('Successfully')
                    ->success()
                    ->send();
            });
    }
}
