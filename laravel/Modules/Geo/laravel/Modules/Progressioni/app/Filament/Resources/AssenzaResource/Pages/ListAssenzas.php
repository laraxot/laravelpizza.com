<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzaResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\AssenzaResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListAssenzas extends PtvBaseYearListRecords
{
    protected static string $resource = AssenzaResource::class;

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
            'tipo' => TextColumn::make('tipo')
                ->numeric()
                ->sortable(),
            'codice' => TextColumn::make('codice')
                ->numeric()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'umi' => TextColumn::make('umi')
                ->sortable(),
            'dur' => TextColumn::make('dur')
                ->sortable(),
        ];
    }
}
