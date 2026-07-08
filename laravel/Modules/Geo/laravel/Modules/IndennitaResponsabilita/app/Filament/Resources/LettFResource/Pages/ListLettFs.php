<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\IndennitaResponsabilita\Filament\Resources\LettFResource;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListLettFs extends XotBaseListRecords
{
    protected static string $resource = LettFResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<string, Tables\Columns\Column>
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
     * Get the table filters definition.
     *
     * @return array<string, BaseFilter>
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
