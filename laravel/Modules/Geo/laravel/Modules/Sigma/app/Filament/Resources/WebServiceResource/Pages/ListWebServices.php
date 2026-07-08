<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Resources\WebServiceResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Sigma\Filament\Resources\WebServiceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListWebServices extends XotBaseListRecords
{
    protected static string $resource = WebServiceResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, CreateAction>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
