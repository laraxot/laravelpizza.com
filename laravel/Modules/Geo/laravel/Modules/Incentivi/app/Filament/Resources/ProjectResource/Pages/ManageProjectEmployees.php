<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions\DetachAction;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table\AttachEsternoAction;
use Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table\AttachGroupAction;
use Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table\AttachSingleEmployeeAction;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Override;

class ManageProjectEmployees extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'employees';

    protected static string $recordTitleAttribute = 'nome';

    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            'detach' => DetachAction::make()
                ->disabled(function (Model $employee, Component $livewire): bool {
                    if (! method_exists($livewire, 'getRecord')) {
                        return false;
                    }
                    $record = $livewire->getRecord();
                    if ($record === null || ! is_object($record) || ! isset($record->id)) {
                        return false;
                    }
                    /** @var Employee $employee */
                    if (! isset($employee->activities) || ! is_object($employee->activities)) {
                        return false;
                    }
                    /** @var \Illuminate\Support\Collection $activities */
                    $activities = $employee->activities;
                    $sum = $activities->where('project_id', $record->id)->sum('pivot.importo_attivita_dipendente');

                    return is_numeric($sum) && (float) $sum > 0;
                }),
        ];
    }

    public function getTableHeaderActions(): array
    {
        // Types are inferred by Filament v4
        return [
            // ...parent::getTableHeaderActions(),
            'AttachSingleEmployeeAction' => AttachSingleEmployeeAction::make('AttachSingleEmployeeAction'),
            'AttachGroupAction' => AttachGroupAction::make('AttachGroupAction'),
            'AttachEsternoAction' => AttachEsternoAction::make('AttachEsternoAction'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        return [
        ];
    }

    public function getTableRecordTitleAttribute(): string
    {
        return 'cognome';
    }

    // public static function sumPerYear(int $year): float
    // {
    //     return fn(Model $record): float =>
    //     (float) ($record->activities->where('anno_competenza', $year)->sum('pivot.importo_attivita_dipendente'));
    // }

    public static function sumPerColumn(int $year, mixed $livewire): float
    {
        $sum = 0;
        if (! is_object($livewire) || ! method_exists($livewire, 'getRecord')) {
            return 0.0;
        }

        $record = $livewire->getRecord();
        if ($record === null || ! ($record instanceof Project)) {
            return 0.0;
        }

        $activities = $record->activities()->with('employees')->where('anno_competenza', $year)->get();
        /** @var Activity $activity */
        foreach ($activities as $activity) {
            // Using documented relationship from @property-read in Activity model
            foreach ($activity->employees->where('tipologia', 'I') as $employee) {
                $pivot = $employee->pivot;
                // property_exists() non può essere usato sui modelli Eloquent perché gli attributi sono magici
                // Usiamo isset() che rispetta i magic methods __isset() di Eloquent
                if ($pivot && isset($pivot->importo_attivita_dipendente)) {
                    $importo = $pivot->importo_attivita_dipendente;
                    $sum += is_numeric($importo) ? (float) $importo : 0.0;
                }
            }
        }

        return $sum;
    }

    public static function sumPerColumnTotal(mixed $livewire): float
    {
        $sum = 0;
        if (! is_object($livewire) || ! method_exists($livewire, 'getRecord')) {
            return 0.0;
        }

        $record = $livewire->getRecord();
        if ($record === null || ! ($record instanceof Project)) {
            return 0.0;
        }

        $activities = $record->activities()->with('employees')->get();

        /** @var Activity $activity */
        foreach ($activities as $activity) {
            $employees = $activity->employees->where('tipologia', 'I');
            foreach ($employees as $employee) {
                $pivot = $employee->pivot;
                if (! is_object($pivot)) {
                    continue;
                }

                $amount = $pivot->importo_attivita_dipendente ?? null;
                if (! is_numeric($amount)) {
                    continue;
                }

                $sum += (float) $amount;
            }
        }

        return $sum;
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Multiple @var tags removed - types inferred by Filament v4
        $cols = [
            'matricola' => TextColumn::make('matricola')
                ->searchable()
                ->sortable(),
            'cognome' => TextColumn::make('cognome')
                ->searchable()
                ->sortable(),
            'nome' => TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            // Tables\Columns\TextColumn::make('sesso'),
            'codice_fiscale' => TextColumn::make('codice_fiscale'),
            // 'posizione_inail' => TextColumn::make('posizione_inail'),
        ];

        $record = $this->getRecord();

        // foreach ($uniqueYears as $year) {
        //     $cols[] = Tables\Columns\TextColumn::make('sum_'.$year)
        //         ->label('Anno '.$year)
        //         ->default($this->sumPerYear($year))
        //         ->money('EUR')
        //         ->summarize(
        //             Summarizer::make()
        //             ->label('Totale')
        //             ->using(fn($livewire) => $livewire->sumPerColumn($year, $livewire))
        //             ->money('EUR')
        //             ) ;
        // }

        $cols['sum_total_row'] = TextColumn::make('sum_total_row')
            ->default(
                function (Employee $employee, Component $livewire): float {
                    if (! method_exists($livewire, 'getRecord')) {
                        return 0.0;
                    }
                    $record = $livewire->getRecord();
                    if ($record === null || ! is_object($record) || ! isset($record->id)) {
                        return 0.0;
                    }
                    /** @var \Illuminate\Support\Collection $activities */
                    $activities = $employee->activities ?? collect();
                    $sum = $activities->where('project_id', $record->id)->sum('pivot.importo_attivita_dipendente');

                    return is_numeric($sum) ? (float) $sum : 0.0;
                }
            )
            ->money('EUR')
            ->summarize(Summarizer::make()
                ->label('Totale')
                ->using(fn ($livewire) => static::sumPerColumnTotal($livewire))
                ->money('EUR')
            );

        return $cols;
    }
}
