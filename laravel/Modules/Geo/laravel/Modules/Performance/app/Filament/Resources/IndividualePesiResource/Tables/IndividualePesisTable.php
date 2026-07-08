<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePesiResource\Tables;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Enums\WorkerType;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class IndividualePesisTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'type' => TextColumn::make('type')
                ->searchable()
                ->sortable()
                ->badge(),
            'lista_propro' => TextColumn::make('lista_propro')
                ->searchable()
                ->sortable()
                ->wrap(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->sortable(),
            'peso_esperienza_acquisita' => TextColumn::make('peso_esperienza_acquisita')
                ->numeric()
                ->sortable(),
            'peso_risultati_ottenuti' => TextColumn::make('peso_risultati_ottenuti')
                ->numeric()
                ->sortable(),
            'peso_arricchimento_professionale' => TextColumn::make('peso_arricchimento_professionale')
                ->numeric()
                ->sortable(),
            'peso_impegno' => TextColumn::make('peso_impegno')
                ->numeric()
                ->sortable(),
            'peso_qualita_prestazione' => TextColumn::make('peso_qualita_prestazione')
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
            'created_by' => TextColumn::make('created_by')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_by' => TextColumn::make('updated_by')
                ->searchable()
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
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class),
            'pesi_non_zero' => Filter::make('pesi_non_zero')
                ->query(fn (Builder $query): Builder => $query
                    ->where('peso_esperienza_acquisita', '>', 0)
                    ->orWhere('peso_risultati_ottenuti', '>', 0)
                    ->orWhere('peso_arricchimento_professionale', '>', 0)
                    ->orWhere('peso_impegno', '>', 0)
                    ->orWhere('peso_qualita_prestazione', '>', 0)
                ),
            'lista_propro' => Filter::make('lista_propro')
                ->schema([
                    TextInput::make('value'),
                ])
                ->query(fn (Builder $query, array $data): Builder => $query->when(
                    $data['value'] ?? null,
                    fn (Builder $query, $value): Builder => $query->where('lista_propro', 'like', '%'.(string) $value.'%')
                )),
        ];
    }
}
