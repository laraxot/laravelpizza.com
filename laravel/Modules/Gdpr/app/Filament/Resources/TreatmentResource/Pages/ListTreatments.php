<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Pages;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Gdpr\Filament\Resources\TreatmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListTreatments extends XotBaseListRecords
{
    protected static string $resource = TreatmentResource::class;

    public function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('id')
            //     ->searchable(),
            IconColumn::make('active')->boolean(),
            IconColumn::make('required')->boolean(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('documentVersion')->searchable(),
            TextColumn::make('documentUrl')->searchable(),
            TextColumn::make('weight')->numeric()->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
