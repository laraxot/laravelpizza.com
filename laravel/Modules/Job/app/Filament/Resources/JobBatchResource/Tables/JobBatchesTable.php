<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobBatchResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Artisan;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * JobBatchesTable Schema.
 */
class JobBatchesTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('total_jobs')->sortable(),
            TextColumn::make('pending_jobs')->sortable(),
            TextColumn::make('failed_jobs')->sortable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'prune_batches' => Action::make('prune_batches')
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

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
