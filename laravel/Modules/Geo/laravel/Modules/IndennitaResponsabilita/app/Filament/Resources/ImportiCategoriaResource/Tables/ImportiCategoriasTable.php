<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\IndennitaResponsabilita\Models\ImportiCategoria;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ImportiCategoriasTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
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
     * @return array<string, mixed>
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
