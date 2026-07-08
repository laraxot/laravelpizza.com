<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Incentivi\Models\Project;
use Spatie\QueueableAction\QueueableAction;

class UpdateProjectActivitiesAction
{
    // use QueueableAction;

    // /**
    //  * Update activities and their employees based on project componente_incentivante.
    //  *
    //  * @param  Project|Model|null  $record  Project model instance
    //  */
    // public function execute(Project|Model|null $record): void
    // {
    //     $project = $this->ensureProjectInstance($record);
    //     if ($project === null) {
    //         return;
    //     }

    //     $activities = $this->getActivities($project);

    //     $incentiveComponent = isset($project->componente_incentivante) && is_numeric($project->componente_incentivante)
    //         ? floatval($project->componente_incentivante)
    //         : 0.0;

    //     foreach ($activities as $activity) {
    //         $this->updateActivityAndEmployees($activity, $incentiveComponent);
    //     }
    // }

    // /**
    //  * Ensure the record is a Project instance.
    //  */
    // private function ensureProjectInstance(Project|Model|null $record): ?Project
    // {
    //     if (! $record instanceof Project) {
    //         return null;
    //     }

    //     return $record;
    // }

    // /**
    //  * Get the activities collection for a project.
    //  */
    // private function getActivities(Project $project): Collection
    // {
    //     $activitiesRelation = $project->activities ?? null;
    //     if ($activitiesRelation instanceof Collection) {
    //         return $activitiesRelation;
    //     }
    //     if ($activitiesRelation instanceof SupportCollection) {
    //         return $activitiesRelation;
    //     }

    //     return collect();
    // }



    // private function updateEmployeePivot(Model $employee, float $importoAttivita): void
    // {
    //    if (! is_object($employee)) {
    //         continue;
    //     }

    //     // Access pivot property safely
    //     $pivot = isset($employee->pivot) ? $employee->pivot : null;
    //     if ($pivot === null || ! is_object($pivot) || ! $pivot instanceof Model) {
    //         continue;
    //     }

    //     $percentualeAttivitaDipendente = isset($pivot->percentuale_attivita_dipendente)
    //         ? $pivot->percentuale_attivita_dipendente
    //         : 0;
    //     $percentualeFloat = is_numeric($percentualeAttivitaDipendente)
    //         ? floatval($percentualeAttivitaDipendente)
    //         : 0.0;

    //     $pivot->update([
    //         'importo_attivita_dipendente' => $importoAttivita * ($percentualeFloat / 100),
    //     ]);
    // }



    // /**
    //  * Update a single activity and its employees.
    //  */
    // private function updateActivityAndEmployees(Model $activity, float $incentiveComponent): void
    // {
    //     // Type narrowing: ensure activity is an object and Model instance
    //     if (! is_object($activity) || ! $activity instanceof Model) {
    //         return;
    //     }

    //     $quotaPercentuale = isset($activity->quota_percentuale) && is_numeric($activity->quota_percentuale)
    //         ? floatval($activity->quota_percentuale)
    //         : 0.0;
    //     $importoAttivita = $incentiveComponent * ($quotaPercentuale / 100);

    //     $activity->update([
    //         'importo' => $importoAttivita,
    //     ]);

    //     // Get employees relation - can be Collection or BelongsToMany result
    //     $employeesRelation = $activity->employees ?? null;
    //     $employees = $employeesRelation instanceof Collection
    //         ? $employeesRelation
    //         : ($employeesRelation instanceof SupportCollection
    //             ? $employeesRelation
    //             : collect());

    //     foreach ($employees as $employee) {
    //         $this->updateEmployeePivot($employee, $importoAttivita);
    //     }
    // }



     use QueueableAction;

    /**
     * Update activities and their employees based on project componente_incentivante.
     *
     * @param Project|Model|null $record Project model instance
     */
    public function execute(Project|Model|null $record): void
    {
        if (! $record) {
            return;
        }

        // Ensure we have a Project instance
        if (! $record instanceof Project) {
            return;
        }

        // Get activities relation - can be Collection or HasMany result
        $activitiesRelation = $record->activities ?? null;
        $activities = $activitiesRelation instanceof Collection
            ? $activitiesRelation
            : ($activitiesRelation instanceof SupportCollection
                ? $activitiesRelation
                : collect());


        $componenteIncentivante = isset($record->componente_incentivante) && is_numeric($record->componente_incentivante)
            ? floatval($record->componente_incentivante)
            : 0.0;

        foreach ($activities as $activity) {
            // Type narrowing: ensure activity is an object and Model instance
            if (! is_object($activity) || ! $activity instanceof Model) {
                continue;
            }

            $quotaPercentuale = isset($activity->quota_percentuale) && is_numeric($activity->quota_percentuale)
                ? floatval($activity->quota_percentuale)
                : 0.0;
            $importoAttivita = $componenteIncentivante * ($quotaPercentuale / 100);

            $activity->update([
                'importo' => $importoAttivita,
            ]);

            // Get employees relation - can be Collection or BelongsToMany result
            $employeesRelation = $activity->employees ?? null;
            $employees = $employeesRelation instanceof Collection
                ? $employeesRelation
                : ($employeesRelation instanceof SupportCollection
                    ? $employeesRelation
                    : collect());


            foreach ($employees as $employee) {
                // Type narrowing: ensure employee is an object
                if (! is_object($employee)) {
                    continue;
                }

                // Access pivot property safely
                $pivot = isset($employee->pivot) ? $employee->pivot : null;
                if ($pivot === null || ! is_object($pivot) || ! $pivot instanceof Model) {
                    continue;
                }

                $percentualeAttivitaDipendente = isset($pivot->percentuale_attivita_dipendente)
                    ? $pivot->percentuale_attivita_dipendente
                    : 0;
                $percentualeFloat = is_numeric($percentualeAttivitaDipendente)
                    ? floatval($percentualeAttivitaDipendente)
                    : 0.0;

                $pivot->update([
                    'importo_attivita_dipendente' => $importoAttivita * ($percentualeFloat / 100),
                ]);
            }
        }
    }



}
