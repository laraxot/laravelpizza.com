<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Resources\Pages\ViewRecord as FilamentViewRecord;
use Modules\Xot\Filament\Links\RecordAnchor;

abstract class XotBaseViewRecord extends FilamentViewRecord
{
    use HasFiltersForm;

    /**
     * Get the header actions.
     *
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'back' => Action::make('back')
                ->label(__('filament-panels::resources/pages/view-record.actions.back.label'))
                ->icon('heroicon-o-arrow-left')
                ->url(function (): string {
                    $record = $this->getRecord();
                    $returnTo = request()->query(RecordAnchor::RETURN_TO_PARAMETER);
                    $key = $record->getKey();

                    if (! is_string($returnTo) || (! is_int($key) && ! is_string($key))) {
                        return $this->getResourceUrl();
                    }

                    $returnTo = RecordAnchor::resolveReturnTo($returnTo, $key);

                    return $returnTo ?? $this->getResourceUrl();
                }),
        ];
    }
}
