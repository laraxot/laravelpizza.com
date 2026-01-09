<?php

/**
 * @see https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/resources/FailedJobsResource/Pages/ListFailedJobs.php?ref_type=heads
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedJobResource\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Artisan;
use Modules\Job\Filament\Resources\FailedJobResource;
use Modules\Job\Models\FailedJob;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListFailedJobs extends XotBaseListRecords
{
    protected static string $resource = FailedJobResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'uuid' => TextColumn::make('uuid')
                ->searchable()
                ->sortable()
                ->copyable(),
            'connection' => TextColumn::make('connection')->searchable()->sortable(),
            'queue' => TextColumn::make('queue')->searchable()->sortable(),
            'payload' => TextColumn::make('payload')
                ->searchable()
                ->wrap()
                ->limit(50),
            'exception' => TextColumn::make('exception')
                ->searchable()
                ->wrap()
                ->limit(100),
            'failed_at' => TextColumn::make('failed_at')->dateTime()->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'retry_all' => Action::make('retry_all')
                ->requiresConfirmation()
                ->action(static function (): void {
                    Artisan::call('queue:retry all');
                    Notification::make()
                        ->title('All failed jobs have been pushed back onto the queue.')
                        ->success()
                        ->send();
                }),
            'delete_all' => Action::make('delete_all')
                ->requiresConfirmation()
                ->color('danger')
                ->action(static function (): void {
                    FailedJob::truncate();
                    Notification::make()
                        ->title('All failed jobs have been removed.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
