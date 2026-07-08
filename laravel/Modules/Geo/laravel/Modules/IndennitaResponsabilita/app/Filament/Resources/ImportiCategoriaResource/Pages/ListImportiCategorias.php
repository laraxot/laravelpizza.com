<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource;
use Modules\IndennitaResponsabilita\Models\ImportiCategoria;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListImportiCategorias extends XotBaseListRecords
{
    protected static string $resource = ImportiCategoriaResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'ente' => TextColumn::make('ente')
                ->numeric()
                ->sortable(),

            'categoria' => TextColumn::make('categoria')
                ->searchable()
                ->sortable(),

            'lista_propro' => TextColumn::make('lista_propro')
                ->limit(50)
                ->searchable(),

            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),

            'min' => TextColumn::make('min')
                ->numeric()
                ->sortable()
                ->formatStateUsing(fn (int $state): string => '€ '.number_format($state, 2, ',', '.')),

            'max' => TextColumn::make('max')
                ->numeric()
                ->sortable()
                ->formatStateUsing(fn (int $state): string => '€ '.number_format($state, 2, ',', '.')),

            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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
                    $years = ImportiCategoria::distinct('anno')
                        ->orderBy('anno', 'desc')
                        ->pluck('anno', 'anno')
                        ->toArray();

                    return $years;
                })
                ->default((int) date('Y')),

            'ente' => SelectFilter::make('ente')
                ->options(function (): array {
                    /** @var array<int, int> $enti */
                    $enti = ImportiCategoria::distinct('ente')
                        ->orderBy('ente')
                        ->pluck('ente', 'ente')
                        ->toArray();

                    return $enti;
                }),
        ];
    }
}
