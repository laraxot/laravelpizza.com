<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListProjects extends XotBaseListRecords
{
    protected static string $resource = ProjectResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'nome' => TextColumn::make('nome')
                ->searchable()
                ->limit(50)
                ->wrap(),
            'tipo' => TextColumn::make('tipo')
                ->searchable(),
            TextColumn::make('stabiDirigente.nome_stabi')
                ->sortable(),
            'stato' => TextColumn::make('stato')
                ->badge()
                ->sortable(),
            'data_aggiudicazione' => TextColumn::make('data_aggiudicazione')
                ->dateTime('D, d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'data_inizio_esecuzione' => TextColumn::make('data_inizio_esecuzione')
                ->dateTime('D, d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'data_fine_esecuzione' => TextColumn::make('data_fine_esecuzione')
                ->dateTime('D, d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            // Tables\Columns\TextColumn::make('oggetto')
            //     ->searchable()
            //     ->limit(30),
            TextColumn::make('determina di aggiudicazione')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            'percentuale_fondo' => TextColumn::make('percentuale_fondo')
                ->searchable()
                ->suffix(' %'),
            'importo_totale' => TextColumn::make('importo_totale')
                ->money('EUR')
                ->searchable(),
            'importo_effettivo_fondo' => TextColumn::make('importo_effettivo_fondo')
                ->money('EUR')
                ->searchable(),
            'componente_incentivante' => TextColumn::make('componente_incentivante')
                ->money('EUR')
                ->searchable(),
            'componente_innovazione' => TextColumn::make('componente_innovazione')
                ->money('EUR')
                ->searchable(),
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

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            // 'log' => ListLogActivitiesAction::make(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        /** @var UserContract|null $user */
        $user = Auth::user();

        if (! $user?->hasRole(['super-admin', 'incentivi-admin'])) {
            return [];
        }

        return [
            'delete' => DeleteBulkAction::make()
                ->label('Elimina')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {        
        return [
        ];
    }
}
