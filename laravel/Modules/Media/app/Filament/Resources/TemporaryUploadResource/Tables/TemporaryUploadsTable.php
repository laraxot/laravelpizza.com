<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Media\Models\TemporaryUpload;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TemporaryUploadsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'file_name' => TextColumn::make('file_name')->searchable()->placeholder('—'),
            'mime_type' => TextColumn::make('mime_type')->placeholder('—')->toggleable(),
            'file_size' => TextColumn::make('file_size')->numeric()->placeholder('—')->toggleable(),
            'status' => TextColumn::make('status')->badge(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, SelectFilter>
     */
    public function getTableFilters(): array
    {
        return [
            // La tabella temporary_uploads non ha una colonna "folder" (il filtro precedente dava errore 500):
            // si filtra per stato dell'upload.
            'status' => SelectFilter::make('status')->options(
                static fn (): array => TemporaryUpload::query()->distinct()->whereNotNull('status')->pluck('status', 'status')->toArray(),
            ),
        ];
    }

    /**
     * @return array<string, ViewAction|EditAction|DeleteAction>
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
     * @return array<string, DeleteBulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
