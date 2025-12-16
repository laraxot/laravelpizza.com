<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Gdpr\Filament\Resources\EventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListEvents extends XotBaseListRecords
{
    protected static string $resource = EventResource::class;

    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'treatment_id' => TextColumn::make('treatment_id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'consent_id' => TextColumn::make('consent.id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'subject_id' => TextColumn::make('subject_id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'ip' => TextColumn::make('ip')->searchable(),
            'action' => TextColumn::make('action')->searchable(),
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
