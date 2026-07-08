<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Actions;

use Closure;
use Filament\Actions\AttachAction;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;
use Modules\Incentivi\Models\Activity;


class AttachActivityEmployeeAction extends AttachAction
{
    protected function setUp(): void
    {
       parent::setUp();

       $this->icon('heroicon-o-link')
                ->disabled(function (RelationManager $livewire): bool {
                    $activity = $livewire->getOwnerRecord();

                    if (! $activity instanceof Activity) {
                        return false;
                    }

                    $totalExistingPercentage = (float) $activity->employees()
                        ->sum('activity_employee.percentuale_attivita_dipendente');

                    return $totalExistingPercentage >= 100.0;
                })
                ->before(function (AttachAction $action, RelationManager $livewire, array $data): void {
                    $activity = $livewire->getOwnerRecord();

                    if (! $activity instanceof Activity) {
                        return;
                    }

                    $selectedEmployeeId = $data['recordId'] ?? null;
                    $percentuale = isset($data['percentuale_attivita_dipendente']) && is_numeric($data['percentuale_attivita_dipendente'])
                        ? (float) $data['percentuale_attivita_dipendente']
                        : 0.0;

                    $existingTotal = (float) $activity->employees()
                        ->when(
                            $selectedEmployeeId !== null,
                            fn ($q) => $q->where('employees.id', '<>', $selectedEmployeeId)
                        )
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
                ->recordSelectOptionsQuery(
                    function (Builder $query, RelationManager $livewire): Builder {
                        $ownerRecord = $livewire->getOwnerRecord();
                        $projectId = null;

                        if ($ownerRecord instanceof Activity) {
                            $project = $ownerRecord->project ?? null;
                            if ($project instanceof Model && isset($project->id)) {
                                $projectId = $project->id;
                            }
                        }

                        if ($projectId !== null) {
                            return $query->whereHas('projects', function (Builder $query1) use ($projectId): void {
                                $query1->where('projects.id', $projectId);
                            });
                        }

                        return $query;
                    }
                )
                ->preloadRecordSelect()
                ->recordSelectSearchColumns(['cognome', 'nome'])
                ->recordTitle(function (Model $record): string {
                    $nome = isset($record->nome) && is_string($record->nome) ? $record->nome : '';
                    $cognome = isset($record->cognome) && is_string($record->cognome) ? $record->cognome : '';

                    return trim("{$nome} {$cognome}");
                })
                ->schema(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    TextInput::make('project_id')
                        ->default(function (RelationManager $livewire): ?int {
                            $ownerRecord = $livewire->getOwnerRecord();

                            if ($ownerRecord instanceof Activity) {
                                $project = $ownerRecord->project ?? null;
                                if ($project instanceof Model && isset($project->id)) {
                                    return (int) $project->id;
                                }
                            }

                            return null;
                        })
                        ->disabled()
                        ->dehydrated(),
                    TextInput::make('percentuale_attivita_dipendente')
                        ->required()
                        ->numeric()
                        ->inputMode('numeric')
                        ->minValue(1)
                        ->maxValue(100)
                        ->suffix('%')
                        ->live(debounce: 600)
                        ->helperText(function (RelationManager $livewire): string {
                            $activity = $livewire->getOwnerRecord();
                            $totalExistingPercentage = ($activity instanceof Activity)
                                ? (float) $activity->employees()->sum('activity_employee.percentuale_attivita_dipendente')
                                : 0.0;

                            $disponibile = 100.0 - $totalExistingPercentage;

                            return "Percentuale già allocata: {$totalExistingPercentage}%. Disponibile: {$disponibile}%.";
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
                ]);
    }

    public static function getDefaultName(): ?string
    {
        return 'Collega Dipendente';
    }
}
