<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Illuminate\Support\Arr;
use Modules\Progressioni\Actions\RefreshByYearAction;
use Modules\Progressioni\Models\Progressioni;

class RicalcolaAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'ricalcola';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip('Ricalcola')
            ->icon('fas-retweet')
            ->action(function (ListRecords $livewire): void {
                $resource = $livewire->getResource();
                /** @var class-string<resource> $resource */
                $modelClass = $resource::getModel();
                /** @var class-string<Progressioni> $modelClass */
                $tableFilters = $livewire->tableFilters ?? [];
                /** @var array<string, mixed> $tableFilters */
                $year = Arr::get($tableFilters, 'anno.value');
                // 2023

                if ($year === null) {
                    return;
                }

                $fieldname = 'anno';
                app(RefreshByYearAction::class)->execute($modelClass, $fieldname, (string) $year);
                Notification::make()
                    ->title('Successfully')
                    ->success()
                    ->send();
            });
    }
}
