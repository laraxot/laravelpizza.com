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
use Modules\Xot\Actions\ModelClass\CopyFromLastYearAction as CopyFromLastYearByFieldnameAction;

class CopyFromLastYearAction extends Action
{
    public ?string $yearFieldName = null;

    public static function getDefaultName(): ?string
    {
        return 'copy_from_last_year_';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip(__('ptv::scheda.actions.copy_from_last_year'))
            ->icon('heroicon-o-document-duplicate')
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
                if ($year == null) {
                    $year = Arr::get($tableFilters, 'year.value');
                    // 2023
                    $fieldname = 'year';
                }
                if (is_string($this->yearFieldName)) {
                    $fieldname = $this->yearFieldName;
                }

                app(CopyFromLastYearByFieldnameAction::class)->execute($modelClass, $fieldname, is_string($year) ? $year : '');
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

    public function setYearFieldName(string $yearFieldName): self
    {
        $this->yearFieldName = $yearFieldName;

        return $this;
    }
}
