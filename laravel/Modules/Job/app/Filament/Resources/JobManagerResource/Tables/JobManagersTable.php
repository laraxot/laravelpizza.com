<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobManagerResource\Tables;

<<<<<<< HEAD
=======
use Filament\Actions\DeleteBulkAction;
>>>>>>> 40b96bcd6 (.)
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class JobManagersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
<<<<<<< HEAD
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'job_id' => TextColumn::make('job_id')->searchable()->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'queue' => TextColumn::make('queue')->searchable()->sortable(),
            'status' => TextColumn::make('status')->badge()->sortable(),
            'failed' => TextColumn::make('failed')->badge()->sortable(),
            'attempt' => TextColumn::make('attempt')->sortable(),
            'progress' => TextColumn::make('progress')->sortable(),
            'started_at' => TextColumn::make('started_at')->dateTime()->sortable(),
            'finished_at' => TextColumn::make('finished_at')->dateTime()->sortable(),
            'exception_message' => TextColumn::make('exception_message')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
=======
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
