<?php

declare(strict_types=1);

/**
 * ---.
 */

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Job\Filament\Resources\JobsWaitingResource;
use Modules\Job\Filament\Resources\JobsWaitingResource\Widgets\JobsWaitingOverview;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListJobsWaiting extends XotBaseListRecords
{
    public static string $resource = JobsWaitingResource::class;

    public function getHeaderWidgets(): array
    {
        return [
            JobsWaitingOverview::class,
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'queue' => TextColumn::make('queue')->searchable()->sortable(),
            'display_name' => TextColumn::make('display_name')
                ->searchable()
                ->sortable()
                ->wrap(),
            'status' => TextColumn::make('status')
                ->badge()
                ->sortable()
                ->color(static fn (string $state): string => match ($state) {
                    'running' => 'primary',
                    'waiting' => 'success',
                    'failed' => 'danger',
                    default => 'secondary',
                }),
            'attempts' => TextColumn::make('attempts')->numeric()->sortable(),
            'available_at' => TextColumn::make('available_at')->dateTime()->sortable(),
            'reserved_at' => TextColumn::make('reserved_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }
}
