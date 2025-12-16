<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\Activity\Filament\Resources\SnapshotResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * @see SnapshotResource
 */
class ListSnapshots extends XotBaseListRecords
{
    protected static string $resource = SnapshotResource::class;

    /**
     * Get the list table columns.
     *
     * @return array<Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable()->searchable(),
            TextColumn::make('aggregate_uuid')->searchable(),
            TextColumn::make('aggregate_version')->sortable(),
            TextColumn::make('state')->searchable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
            TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }

    /**
     * @return array<BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('aggregate_type')
                ->options([
                    'user' => 'User',
                    'profile' => 'Profile',
                    'role' => 'Role',
                ])
                ->multiple(),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
