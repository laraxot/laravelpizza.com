<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Filament\Actions\Table\IndividualeSpreadMoneyAction;
use Modules\Performance\Filament\Actions\Table\OrganizzativaSpreadMoneyAction;
use Modules\Performance\Filament\Resources\PerformanceFondoResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListPerformanceFondos extends PtvBaseYearListRecords
{
    protected static string $resource = PerformanceFondoResource::class;

   
    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'quota_individuale' => TextColumn::make('quota_individuale')
                ->label('Quota Individuale')
                ->numeric()
                ->sortable(),
            'quota_organizzativa' => TextColumn::make('quota_organizzativa')
                ->label('Quota Organizzativa')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->label('Anno')
                ->numeric()
                ->sortable(),
            'note' => TextColumn::make('note')
                ->label('Note')
                ->searchable()
                ->sortable()
                ->wrap(),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->label('Ultima Modifica')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_by' => TextColumn::make('created_by')
                ->label('Creato da')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_by' => TextColumn::make('updated_by')
                ->label('Modificato da')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

   

    #[Override]
    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),
            'organizzativa' => OrganizzativaSpreadMoneyAction::make(),
            'individuale' => IndividualeSpreadMoneyAction::make(),
        ];
    }

   
}
