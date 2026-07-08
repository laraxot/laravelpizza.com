<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\QueueableAction\QueueableAction;

class UpdateActivitiesEmployeesAction
{
    use QueueableAction;

    /**
     * Update employees pivot data based on record importo.
     *
     * @param  Model|null  $record  Project or Activity model instance
     */
    public function execute(?Model $record): void
    {
        if ($record === null) {
            return;
        }

        // Get employees relation - can be Collection or BelongsToMany result
        $employeesRelation = $record->employees ?? null;
        $employees = $employeesRelation instanceof Collection
            ? $employeesRelation
            : ($employeesRelation instanceof SupportCollection
                ? $employeesRelation
                : collect());

        // Handle different model types - Project has 'importo_totale', Activity has 'importo'
        $importoValue = $record->importo_totale ?? $record->importo ?? 0;
        $importo = is_numeric($importoValue) ? floatval($importoValue) : 0.0;

        foreach ($employees as $employee) {
            if (! $employee instanceof Model) {
                continue;
            }
            $this->updateEmployeePivot($employee, $importo);
        }
    }

    /**
     * Update a single employee's pivot data.
     */
    private function updateEmployeePivot(Model $employee, float $importo): void
    {
        $pivot = $employee->pivot ?? null;
        if ($pivot === null || ! is_object($pivot)) {
            return;
        }

        $activityPercentage = isset($pivot->percentuale_attivita_dipendente)
            ? $pivot->percentuale_attivita_dipendente
            : 0;
        $percentualeFloat = is_numeric($activityPercentage)
            ? floatval($activityPercentage)
            : 0.0;

        // Pivot must be a Model instance to call update()
        if ($pivot instanceof Model) {
            $pivot->update([
                'importo_attivita_dipendente' => $importo * ($percentualeFloat / 100),
            ]);
        }
    }
}
