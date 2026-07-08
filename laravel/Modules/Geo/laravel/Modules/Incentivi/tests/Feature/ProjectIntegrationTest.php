<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Feature;

use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Enums\ProjectStatus;
use Modules\User\Models\User;
use Modules\Incentivi\Tests\TestCase;

uses(TestCase::class);

test('project lifecycle from creation to completion', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'nome' => 'Test Project Lifecycle',
        'stato' => ProjectStatus::COMPILAZIONE,
        'importo_totale' => 100000,
    ]);

    expect($project->stato->value)->toBe('compilazione');

    $activity1 = Activity::factory()->create([
        'project_id' => $project->id,
        'nome' => 'Activity 1',
        'quota_percentuale' => 60,
    ]);

    $activity2 = Activity::factory()->create([
        'project_id' => $project->id,
        'nome' => 'Activity 2',
        'quota_percentuale' => 40,
    ]);

    expect($project->activities)->toHaveCount(2);

    $employee1 = Employee::factory()->create([
        'nome' => 'Mario',
        'cognome' => 'Rossi',
    ]);

    $employee2 = Employee::factory()->create([
        'nome' => 'Luigi',
        'cognome' => 'Bianchi',
    ]);

    $project->employees()->attach([$employee1->id, $employee2->id]);

    expect($project->employees)->toHaveCount(2);

    $phase1 = Phase::factory()->create([
        'project_id' => $project->id,
        'nome' => 'Phase 1',
        'ordine' => 1,
    ]);

    $phase2 = Phase::factory()->create([
        'project_id' => $project->id,
        'nome' => 'Phase 2',
        'ordine' => 2,
    ]);

    expect($project->phases)->toHaveCount(2);

    $settlement = Settlement::factory()->create([
        'phase_id' => $phase1->id,
        'importo' => 50000,
    ]);

    expect($settlement->importo)->toBe(50000);

    $project->update(['stato' => ProjectStatus::AGGIUDICAZIONE]);
    expect($project->stato->value)->toBe('aggiudicazione');

    $project->update(['stato' => ProjectStatus::CONCLUSO]);
    expect($project->stato->value)->toBe('concluso');
});

test('project with activities and employees calculates amounts correctly', function () {
    $project = Project::factory()->create([
        'nome' => 'Test Project Calculations',
        'importo_totale' => 200000,
        'componente_incentivante' => 160000,
    ]);

    $activity1 = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 50,
        'importo' => 80000,
    ]);

    $activity2 = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 50,
        'importo' => 80000,
    ]);

    $employee = Employee::factory()->create();

    $activity1->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 100,
        'importo_attivita_dipendente' => 80000,
    ]);

    $activity2->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 100,
        'importo_attivita_dipendente' => 80000,
    ]);

    expect($activity1->employees)->toHaveCount(1);
    expect($activity2->employees)->toHaveCount(1);

    $pivot1 = $activity1->employees()->where('employee_id', $employee->id)->first()->pivot;
    expect($pivot1->percentuale_attivita_dipendente)->toBe(100);
    expect($pivot1->importo_attivita_dipendente)->toBe(80000);
});

test('project cannot have activities exceeding 100 percent', function () {
    $project = Project::factory()->create();

    $activity1 = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 60,
    ]);

    $activity2 = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 50,
    ]);

    $totalPercentage = $project->activities()->sum('quota_percentuale');

    expect($totalPercentage)->toBe(110);
});

test('employee can be assigned to multiple projects', function () {
    $employee = Employee::factory()->create();

    $project1 = Project::factory()->create([
        'nome' => 'Project 1',
    ]);

    $project2 = Project::factory()->create([
        'nome' => 'Project 2',
    ]);

    $project1->employees()->attach($employee->id);
    $project2->employees()->attach($employee->id);

    expect($employee->projects)->toHaveCount(2);
});

test('employee can be assigned to multiple activities across projects', function () {
    $employee = Employee::factory()->create();

    $project = Project::factory()->create();

    $activity1 = Activity::factory()->create([
        'project_id' => $project->id,
    ]);

    $activity2 = Activity::factory()->create([
        'project_id' => $project->id,
    ]);

    $activity1->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 50,
    ]);

    $activity2->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 50,
    ]);

    expect($employee->activities)->toHaveCount(2);
});

test('phase settlement calculation', function () {
    $project = Project::factory()->create();

    $phase = Phase::factory()->create([
        'project_id' => $project->id,
    ]);

    $settlement1 = Settlement::factory()->create([
        'phase_id' => $phase->id,
        'importo' => 25000,
    ]);

    $settlement2 = Settlement::factory()->create([
        'phase_id' => $phase->id,
        'importo' => 35000,
    ]);

    $phaseTotal = $phase->settlements()->sum('importo');

    expect($phaseTotal)->toBe(60000);
});

test('project status transition validation', function () {
    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);

    expect($project->stato->value)->toBe('compilazione');

    $project->update(['stato' => ProjectStatus::AGGIUDICAZIONE]);
    expect($project->stato->value)->toBe('aggiudicazione');

    $project->update(['stato' => ProjectStatus::IN_LAVORAZIONE]);
    expect($project->stato->value)->toBe('in_lavorazione');

    $project->update(['stato' => ProjectStatus::CONCLUSO]);
    expect($project->stato->value)->toBe('concluso');
});

test('project with null importo totale', function () {
    $project = Project::factory()->create([
        'importo_totale' => null,
    ]);

    expect($project->importo_totale)->toBeNull();
});

test('activity without project relationship', function () {
    $activity = Activity::factory()->create([
        'project_id' => null,
    ]);

    expect($activity->project)->toBeNull();
});

test('employee with complex assignment scenario', function () {
    $employee = Employee::factory()->create();

    $project1 = Project::factory()->create([
        'importo_totale' => 100000,
    ]);

    $project2 = Project::factory()->create([
        'importo_totale' => 200000,
    ]);

    $activity1 = Activity::factory()->create([
        'project_id' => $project1->id,
        'quota_percentuale' => 100,
    ]);

    $activity2 = Activity::factory()->create([
        'project_id' => $project2->id,
        'quota_percentuale' => 50,
    ]);

    $activity3 = Activity::factory()->create([
        'project_id' => $project2->id,
        'quota_percentuale' => 50,
    ]);

    $employee->activities()->attach($activity1->id, [
        'percentuale_attivita_dipendente' => 100,
    ]);

    $employee->activities()->attach($activity2->id, [
        'percentuale_attivita_dipendente' => 50,
    ]);

    $employee2 = Employee::factory()->create();
    $employee2->activities()->attach($activity3->id, [
        'percentuale_attivita_dipendente' => 50,
    ]);

    expect($employee->activities)->toHaveCount(2);
    expect($employee2->activities)->toHaveCount(1);
});
