<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Modules\Gdpr\Models\Treatment;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TreatmentsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'name' => TextColumn::make('name')->searchable()->sortable()->wrap(),
            'active' => IconColumn::make('active')->boolean()->sortable(),
            'required' => IconColumn::make('required')->boolean()->sortable(),
            'documentVersion' => TextColumn::make('documentVersion')->searchable()->sortable(),
            'documentUrl' => TextColumn::make('documentUrl')->wrap()->url(fn (Treatment $record): ?string => filled($record->documentUrl) ? Str::sanitizeUrl((string) $record->documentUrl) : null)->openUrlInNewTab()->toggleable(isToggledHiddenByDefault: true),
            'weight' => TextColumn::make('weight')->numeric()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
