<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\Incentivi\Models\Employee;
use Modules\Xot\Enums\GenderEnum;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Componenti del Gruppo')
            ->recordTitleAttribute('cognome')
            ->columns([
                TextColumn::make('tipologia'),
                TextColumn::make('matricola'),
                TextColumn::make('cognome'),
                TextColumn::make('nome'),
                TextColumn::make('codice_fiscale'),
            ])
            ->filters([
                SelectFilter::make('tipologia')
                    ->options([
                        'I' => 'Interno',
                        'E' => 'Esterno',
                    ])
                    ->label('Tipologia'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Collega Dipendente')
                    ->preloadRecordSelect(),
                CreateAction::make('newConsulenteEsterno')
                    ->label('Aggiungi nuovo Consulente Esterno')
                    ->color('gray')
                    ->model(Employee::class)
                    ->schema([
                        TextInput::make('cognome')
                            ->required()->string(),
                        TextInput::make('nome')
                            ->required()->string(),
                        Select::make('sesso')
                            ->options(GenderEnum::class)
                            ->required(),
                    ])
                    ->mutateDataUsing(function (array $data): array {
                        $data['matricola'] = null;
                        $data['codice_fiscale'] = null;
                        $data['posizione_inail'] = null;
                        $data['tipologia'] = 'E';

                        return $data;
                    }),
            ])
            ->recordActions([
                // Tables\Actions\EditAction::make(),
                DetachAction::make()
                    ->visible(fn (Employee $record): bool => $record->tipologia == 'I'),
                DeleteAction::make()
                    ->visible(fn (Employee $record): bool => $record->tipologia == 'E'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
