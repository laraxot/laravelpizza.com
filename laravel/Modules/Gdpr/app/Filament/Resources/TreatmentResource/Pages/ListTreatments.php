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
            'active' => IconColumn::make('active')->boolean(),
            'required' => IconColumn::make('required')->boolean(),
            'name' => TextColumn::make('name')->searchable(),
            'documentVersion' => TextColumn::make('documentVersion')->searchable(),
            'documentUrl' => TextColumn::make('documentUrl')->searchable(),
            'weight' => TextColumn::make('weight')->numeric()->sortable(),
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
}
