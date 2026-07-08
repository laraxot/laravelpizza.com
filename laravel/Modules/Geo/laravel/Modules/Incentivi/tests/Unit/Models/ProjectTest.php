<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Collection;

uses(TestCase::class);

test('it can create a project', function () {
    $project = Project::factory()->create([
        'nome' => 'Test Project',
    ]);

    expect($project->nome)->toBe('Test Project');
    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'nome' => 'Test Project',
    ], 'incentivi');
});

test('a project has many activities', function () {
    $project = Project::factory()->create();
    $activities = Activity::factory()->count(3)->create([
        'project_id' => $project->id,
    ]);

    expect($project->activities)->toHaveCount(3);
    expect($project->activities)->toBeInstanceOf(Collection::class);
    expect($project->activities->first())->toBeInstanceOf(Activity::class);
});

test('a project can have many employees', function () {
    $project = Project::factory()->create();
    $employees = Employee::factory()->count(2)->create();

    $project->employees()->attach($employees);

    expect($project->employees)->toHaveCount(2);
    expect($project->employees)->toBeInstanceOf(Collection::class);
    expect($project->employees->first())->toBeInstanceOf(Employee::class);
});

test('a project has many settlements', function () {
    $project = Project::factory()->create();
    $settlements = Settlement::factory()->count(2)->create([
        'project_id' => $project->id,
    ]);

    expect($project->settlements)->toHaveCount(2);
    expect($project->settlements->first())->toBeInstanceOf(Settlement::class);
});

test('a project has many phases', function () {
    $project = Project::factory()->create();
    $phases = Phase::factory()->count(2)->create([
        'project_id' => $project->id,
    ]);

    expect($project->phases)->toHaveCount(2);
    expect($project->phases->first())->toBeInstanceOf(Phase::class);
});

test('a project can have different states', function () {
    $projectCompilazione = Project::factory()->create(['stato' => ProjectStatus::Compilazione]);
    $projectAggiudicazione = Project::factory()->create(['stato' => ProjectStatus::Aggiudicazione]);
    $projectConcluso = Project::factory()->create(['stato' => ProjectStatus::Concluso]);
    $projectCancellato = Project::factory()->create(['stato' => ProjectStatus::Cancellato]);

    expect($projectCompilazione->stato)->toBe(ProjectStatus::Compilazione)
        ->and($projectAggiudicazione->stato)->toBe(ProjectStatus::Aggiudicazione)
        ->and($projectConcluso->stato)->toBe(ProjectStatus::Concluso)
        ->and($projectCancellato->stato)->toBe(ProjectStatus::Cancellato);
});

test('a project has numeric attributes', function () {
    $project = Project::factory()->create([
        'componente_incentivante' => 1600.000,
        'componente_innovazione' => 400.000,
        'importo_totale' => 100000.000,
        'importo_effettivo_fondo' => 2000.000,
        'percentuale_fondo' => 2.0,
    ]);

    expect((float) $project->componente_incentivante)->toBe(1600.0)
        ->and((float) $project->componente_innovazione)->toBe(400.0)
        ->and((float) $project->importo_totale)->toBe(100000.0)
        ->and((float) $project->importo_effettivo_fondo)->toBe(2000.0)
        ->and((float) $project->percentuale_fondo)->toBe(2.0);
});
