<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Job\Models\Schedule;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SchedulesTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }

    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make()
                ->hidden(static fn (Schedule $record): bool => $record->deleted_at !== null)
                ->tooltip(__('filament-support::actions/edit.single.label')),
            'restore' => RestoreAction::make()->tooltip(__('filament-support::actions/restore.single.label')),
            'delete' => DeleteAction::make()->tooltip(__('filament-support::actions/delete.single.label')),
            'forceDelete' => ForceDeleteAction::make()->tooltip(__(
                'filament-support::actions/force-delete.single.label',
            )),
            'history' => ViewAction::make()
                ->icon('history')
                ->color('gray')
                ->tooltip(static::trans('buttons.history')),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
