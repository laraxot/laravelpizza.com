<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\RelationManagers;

use Closure;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Filament\Actions\AttachActivityEmployeeAction;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Rules\Uppercase;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class EmployeesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $recordTitleAttribute = 'cognome';

    public static function getModelLabel(): string
    {
        return __('Dipendente');
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('cognome')
                ->readOnly()
                ->required(),
            TextInput::make('percentuale_attivita_dipendente')
                ->required()
                ->numeric()
                ->suffix('%')
                ->live(onBlur: true)
                // ->rules([
                //     new Uppercase(),
                // ])
                ->rules([
                    fn ($livewire, ?Model $record, Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($livewire, $record, $get) {
                        if (! $livewire instanceof RelationManager) {
                            return;
                        }
                        $activity = $livewire->getOwnerRecord();
                        $relationship = $livewire->getRelationship();
                        if (! $activity instanceof Activity) {
                            return;
                        }
                        if (! $relationship instanceof Builder) {
                            return;
                        }
                        $excludeEmployeeId = $record?->getKey() ?? $get('recordId');
                        $total = $relationship
                            ->where('employees.id', '<>', $excludeEmployeeId)
                            ->sum('activity_employee.percentuale_attivita_dipendente');

                        $total += is_numeric($value) ? (float) $value : 0.0;
                        if ($total > 100) {
                            $fail("La somma totale delle percentuali ({$total}%) supera il 100%.");
                        }
                    },
                ])
                ->helperText(function (RelationManager $livewire): string {
                    $activity = $livewire->getOwnerRecord();
                    $totalExistingPercentage = ($activity instanceof Activity)
                        ? (float) $activity->employees()->sum('activity_employee.percentuale_attivita_dipendente')
                        : 0.0;

                    $disponibile = 100.0 - $totalExistingPercentage;

                    return "Percentuale già allocata: {$totalExistingPercentage}%. Disponibile: {$disponibile}%.";
                })
                ->afterStateUpdated(function (Get $get, Set $set, ?string $state, RelationManager $livewire): void {
                    $ownerRecord = $livewire->getOwnerRecord();
                    if ($ownerRecord instanceof Activity && isset($ownerRecord->importo)) {
                        $percentuale = $state !== null && is_numeric($state) ? (float) $state : 0.0;
                        $importo = is_numeric($ownerRecord->importo) ? (float) $ownerRecord->importo : 0.0;
                        $set('importo_attivita_dipendente', ($percentuale * $importo) / 100.0);
                    }
                }),
            TextInput::make('importo_attivita_dipendente')
                ->numeric()
                ->required()
                ->suffix('€')
                ->disabled()
                ->dehydrated(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'cognome' => TextColumn::make('cognome'),
            'nome' => TextColumn::make('nome'),
            'percentuale_attivita_dipendente' => TextColumn::make('percentuale_attivita_dipendente')
                // ->label('Percentuale attribuita')
                ->suffix('%'),
            // ->summarize(Summarizer::make()
            //     ->label('Total')
            //     ->using(fn ($query): string => $query->count())),
            'importo_attivita_dipendente' => TextColumn::make('importo_attivita_dipendente')
                // ->label('Importo attribuito')
                ->suffix('€'),
        ];
    }

    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
           'attach' => AttachActivityEmployeeAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make()
                ->icon('heroicon-o-pencil')
                ->before(function (EditAction $action, RelationManager $livewire, Model $record, array $data): void {
                    $activity = $livewire->getOwnerRecord();

                    if (! $activity instanceof Activity) {
                        return;
                    }

                    $percentuale = isset($data['percentuale_attivita_dipendente']) && is_numeric($data['percentuale_attivita_dipendente'])
                        ? (float) $data['percentuale_attivita_dipendente']
                        : 0.0;

                    // Escludi il record corrente dalla somma — sta venendo modificato,
                    // quindi il suo valore attuale non deve contare nel totale
                    $existingTotal = (float) $activity->employees()
                        ->where('employees.id', '<>', $record->getKey())
                        ->sum('activity_employee.percentuale_attivita_dipendente');

                    $newTotal = $existingTotal + $percentuale;

                    if ($newTotal > 100) {
                        Notification::make()
                            ->title('Percentuale superata')
                            ->body("La somma totale delle percentuali ({$newTotal}%) supera il 100%.")
                            ->danger()
                            ->persistent()
                            ->send();

                        $action->halt();
                    }
                })
                ->schema([
                    TextInput::make('percentuale_attivita_dipendente')
                        ->required()
                        ->numeric()
                        ->inputMode('numeric')
                        ->minValue(1)
                        ->maxValue(100)
                        ->suffix('%')
                        ->live(debounce: 600)
                        ->helperText(function (RelationManager $livewire, Model $record): string {
                            $activity = $livewire->getOwnerRecord();
                            // Escludi il record corrente dal totale mostrato nell'helper
                            $totalExistingPercentage = ($activity instanceof Activity)
                                ? (float) $activity->employees()
                                    ->where('employees.id', '<>', $record->getKey())
                                    ->sum('activity_employee.percentuale_attivita_dipendente')
                                : 0.0;

                            $disponibile = 100.0 - $totalExistingPercentage;

                            return "Percentuale già allocata per altri Dipendenti: {$totalExistingPercentage}%. Percentuale totale disponibile per questo Dipendente: {$disponibile}%.";
                        })
                        ->afterStateUpdated(function (Set $set, ?string $state, RelationManager $livewire): void {
                            $ownerRecord = $livewire->getOwnerRecord();
                            if ($ownerRecord instanceof Activity && isset($ownerRecord->importo)) {
                                $percentuale = $state !== null && is_numeric($state) ? (float) $state : 0.0;
                                $importo = is_numeric($ownerRecord->importo) ? (float) $ownerRecord->importo : 0.0;
                                $set('importo_attivita_dipendente', ($percentuale * $importo) / 100.0);
                            }
                        }),
                    TextInput::make('importo_attivita_dipendente')
                        // ->label('Importo dell\'attività')
                        ->numeric()
                        ->required()
                        ->suffix('€')
                        ->disabled()
                        ->dehydrated(),
                ]),

            'detach' => DetachAction::make(),
        ];
    }
}
