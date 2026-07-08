<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\PesiResource\Pages;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\PesiResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\UI\Filament\Tables\Columns\DummyActionsColumn;
use Override;

class ListPesis extends PtvBaseYearListRecords
{
    protected static string $resource = PesiResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            // 'actions' => Tables\Columns\ViewColumn::make('azioni')
            //    ->view('progressioni::filament.columns.custom-actions'),
            // DummyActionsColumn::make('azioni'),
            'lista_propro' => TextColumn::make('lista_propro')
                ->searchable()
                ->sortable(),
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
        ];
    }
}
