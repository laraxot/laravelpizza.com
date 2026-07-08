<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListOrganizzativaAssenzes extends PtvBaseYearListRecords
{
    protected static string $resource = OrganizzativaAssenzeResource::class;

   

    #[Override]
    /**
     * @return array<string, mixed>
     */
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'tipo' => TextColumn::make('tipo')
                ->numeric()
                ->sortable(),
            'codice' => TextColumn::make('codice')
                ->numeric()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->wrap(),
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
