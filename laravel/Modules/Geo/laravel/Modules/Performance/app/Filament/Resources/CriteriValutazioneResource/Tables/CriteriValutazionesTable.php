<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriValutazioneResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Enums\WorkerType;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CriteriValutazionesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'id_padre' => TextColumn::make('id_padre')
                ->numeric()
                ->sortable(),
            'nome' => TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            'label' => TextColumn::make('label')
                ->searchable()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable(),
            'post_type' => TextColumn::make('post_type')
                ->searchable()
                ->sortable(),
            'posizione' => TextColumn::make('posizione')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
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

    public function getTableFilters(): array
    {
        return [
            'post_type' => SelectFilter::make('post_type')
                ->options(WorkerType::class),
        ];
    }
}
