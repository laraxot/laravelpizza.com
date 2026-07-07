<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedJobResource\Tables;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Artisan;
use Modules\Job\Models\FailedJob;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FailedJobsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'connection' => TextColumn::make('connection')->searchable()->sortable(),
            'queue' => TextColumn::make('queue')->searchable()->sortable(),
            'failed_at' => TextColumn::make('failed_at')->dateTime()->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
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
