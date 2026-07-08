<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Bulk;

use Filament\Notifications\Notification as FilamentNotification;
use Modules\Ptv\Actions\CriteriEsclusione\CheckCriterio;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Modules\Xot\Filament\Tables\Actions\XotBaseBulkAction;

class CheckCriterioEsclusioneBulkAction extends XotBaseBulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'CheckCriterioEsclusioneBulkAction';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('CheckCriterioEsclusioneBulkAction')
            ->tooltip('CheckCriterioEsclusioneBulkAction')
            ->icon('heroicon-o-shield-check')
            ->action(function ($livewire, $action, $records): void {
                if (! is_iterable($records)) {
                    return;
                }

                $count = 0;
                foreach ($records as $record) {
                    if ($record instanceof CriteriEsclusioneContract) {
                        app(CheckCriterio::class)->execute($record);
                        $count++;
                    }
                }
                // Mostra notifica di Filament con il numero di email inviate
                FilamentNotification::make()
                    ->title('Operazione completata')
                    ->body("Sono state controllati $count criteri.")
                    ->success()
                    ->send();
            });
    }
}
