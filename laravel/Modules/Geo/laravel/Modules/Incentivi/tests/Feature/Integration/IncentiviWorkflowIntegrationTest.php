<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Feature\Integration;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;
use Modules\Incentivi\Actions\UpdateProjectActivitiesAction;
use Modules\Incentivi\Models\Project;

function makeIncentiviIntegrationPivotStub(): Model
{
    return new class extends Model {
        public array $lastUpdated = [];

        public function update(array $attributes = [], array $options = []): bool
        {
            $this->lastUpdated = $attributes;

            return true;
        }
    };
}

function makeIncentiviIntegrationEmployeeStub(mixed $pivot = null): Model
{
    $employee = new class extends Model {
        public mixed $pivot = null;
    };
    $employee->pivot = $pivot;

    return $employee;
}

function makeIncentiviIntegrationActivityStub(): Model
{
    return new class extends Model {
        public array $lastUpdated = [];

        public function update(array $attributes = [], array $options = []): bool
        {
            $this->lastUpdated = $attributes;

            return true;
        }
    };
}

it('runs project to activity to employee amount propagation workflow', function (): void {
    $pivot = makeIncentiviIntegrationPivotStub();
    $employee = makeIncentiviIntegrationEmployeeStub($pivot);
    $employee->pivot->percentuale_attivita_dipendente = 50;

    $activity = makeIncentiviIntegrationActivityStub();
    $activity->quota_percentuale = 20;
    $activity->setRelation('employees', collect([$employee]));

    $project = new Project();
    $project->componente_incentivante = 1000;
    $project->setRelation('activities', collect([$activity]));

    app(UpdateProjectActivitiesAction::class)->execute($project);

    expect($activity->lastUpdated['importo'])->toBe(200.0)
        ->and($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(100.0);

    $record = new class extends Model {
    };
    $record->importo_totale = 500;
    $record->setRelation('employees', collect([$employee]));

    app(UpdateActivitiesEmployeesAction::class)->execute($record);

    expect($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(250.0);
});
