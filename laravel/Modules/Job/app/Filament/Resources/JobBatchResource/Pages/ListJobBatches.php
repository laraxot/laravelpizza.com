<?php

declare(strict_types=1);
/**
 * @see https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/resources/JobBatchesResource/Pages/ListJobBatches.php?ref_type=heads
 */

namespace Modules\Job\Filament\Resources\JobBatchResource\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Modules\Job\Filament\Resources\JobBatchResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListJobBatches extends XotBaseListRecords
{
    protected static string $resource = JobBatchResource::class;

    /**
     * @return array<Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Action::make('prune_batches')
                ->requiresConfirmation()
                ->color('danger')
                ->action(static function (): void {
                    Artisan::call('queue:prune-batches');
                    Notification::make()
                        ->title('All batches have been pruned.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
