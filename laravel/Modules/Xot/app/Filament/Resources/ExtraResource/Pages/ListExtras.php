<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ExtraResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Modules\Xot\Filament\Resources\ExtraResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

/**
 * @see ExtraResource
 */
class ListExtras extends XotBaseListRecords
{
    protected static string $resource = ExtraResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable()->label('ID'),
            'model_type' => TextColumn::make('model_type')->searchable()->label('Model Type'),
            'model_id' => TextColumn::make('model_id')->sortable()->label('Model ID'),
            'extra_attributes' => TextColumn::make('extra_attributes')->searchable()->label('Extra Attributes'),
        ];
    }

    /**
     * @return array<BaseFilter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
