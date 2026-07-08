<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\IndennitaResponsabilita\Models\LettI;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LettIsTable extends XotBaseResourceTable
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

            'stabi' => TextColumn::make('stabi')
                ->numeric()
                ->sortable(),

            'dal' => TextColumn::make('dal')
                ->date()
                ->sortable(),

            'al' => TextColumn::make('al')
                ->date()
                ->sortable(),

            'archivista_informatico' => IconColumn::make('archivista_informatico')
                ->boolean()
                ->sortable(),

            'relazioni_pubblico' => IconColumn::make('relazioni_pubblico')
                ->boolean()
                ->sortable(),

            'protezione_civile' => IconColumn::make('protezione_civile')
                ->boolean()
                ->sortable(),

            'formatore_professionale' => IconColumn::make('formatore_professionale')
                ->boolean()
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
                    $years = LettI::distinct('anno')
                        ->orderBy('anno', 'desc')
                        ->pluck('anno', 'anno')
                        ->toArray();

                    return $years;
                })
                ->default((int) date('Y')),

            'stabi' => SelectFilter::make('stabi')
                ->options(function (): array {
                    /** @var array<int, int> $stabi */
                    $stabi = LettI::distinct('stabi')
                        ->whereNotNull('stabi')
                        ->orderBy('stabi')
                        ->pluck('stabi', 'stabi')
                        ->toArray();

                    return $stabi;
                }),

            'archivista_informatico' => TernaryFilter::make('archivista_informatico'),

            'relazioni_pubblico' => TernaryFilter::make('relazioni_pubblico'),

            'protezione_civile' => TernaryFilter::make('protezione_civile'),

            'formatore_professionale' => TernaryFilter::make('formatore_professionale'),
        ];
    }
}
