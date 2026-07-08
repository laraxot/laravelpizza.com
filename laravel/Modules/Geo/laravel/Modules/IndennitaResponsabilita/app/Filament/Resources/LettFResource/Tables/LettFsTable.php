<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Tables;

use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LettFsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'lavoratore' => WorkerColumn::make('lavoratore'),

            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),

            'posizione_lavoro' => TextColumn::make('posizione_lavoro')
                ->limit(50)
                ->searchable(),

            'complessita' => TextColumn::make('complessita')
                ->numeric()
                ->sortable(),

            'coordinamento' => TextColumn::make('coordinamento')
                ->numeric()
                ->sortable(),

            'responsabilita' => TextColumn::make('responsabilita')
                ->numeric()
                ->sortable(),

            'tot' => TextColumn::make('tot')
                ->numeric()
                ->sortable()
                ->summarize(Average::make()),

            'valore_economico_attribuito' => TextColumn::make('valore_economico_attribuito')
                ->numeric()
                ->sortable()
                ->formatStateUsing(fn (float $state): string => '€ '.number_format($state, 2, ',', '.'))
                ->summarize(Sum::make()
                    ->formatStateUsing(fn (float $state): string => '€ '.number_format($state, 2, ',', '.'))),

            'dal' => TextColumn::make('dal')
                ->date()
                ->sortable(),

            'al' => TextColumn::make('al')
                ->date()
                ->sortable(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'anno' => SelectFilter::make('anno')
                ->options(function (): array {
                    /** @var array<int, int> $years */
                    $years = LettF::distinct('anno')
                        ->orderBy('anno', 'desc')
                        ->pluck('anno', 'anno')
                        ->toArray();

                    return $years;
                })
                ->default((int) date('Y')),

            'stabi' => SelectFilter::make('stabi')
                ->options(function (): array {
                    /** @var array<int, int> $stabi */
                    $stabi = LettF::distinct('stabi')
                        ->whereNotNull('stabi')
                        ->orderBy('stabi')
                        ->pluck('stabi', 'stabi')
                        ->toArray();

                    return $stabi;
                }),
        ];
    }
}
