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
use Illuminate\Support\Arr;
use Modules\Xot\Actions\ModelClass\CopyFromLastYearAction as CopyFromLastYearByFieldnameAction;

class ZipSchedaHeaderAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'zip_scheda';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip('Zip Scheda')
            ->icon('heroicon-o-document-duplicate')
            ->action(function ($livewire, $record, $action) {
                dddx('a');
                /*
                                $modelClass = $livewire->getResource()::getModel();
                                $year = Arr::get($livewire->tableFilters, 'anno.value'); // 2023
                                $fieldname = 'anno';
                                if (null == $year) {
                                    $year = Arr::get($livewire->tableFilters, 'year.value'); // 2023
                                    $fieldname = 'year';
                                }

                                app(CopyFromLastYearByFieldnameAction::class)->execute($modelClass, $fieldname, $year);
                                Notification::make()
                                    ->title('Successfully')
                                    ->success()
                                    ->send();
                                */
            });
    }
}
