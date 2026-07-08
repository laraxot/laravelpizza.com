<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Phase;

uses(TestCase::class);

test('it can create a settlement', function () {
    $settlement = Settlement::factory()->create([
        'denominazione' => 'Settlement Test',
        'tipologia' => 'Tipo A',
        'importo' => '1000.00',
    ]);

    expect($settlement->denominazione)->toBe('Settlement Test')
        ->and($settlement->tipologia)->toBe('Tipo A')
        ->and($settlement->importo)->toBe('1000.00');

    $this->assertDatabaseHas('settlements', [
        'id' => $settlement->id,
        'denominazione' => 'Settlement Test',
    ], 'incentivi');
});

test('a settlement belongs to a project', function () {
    $project = Project::factory()->create();
    $settlement = Settlement::factory()->create([
        'project_id' => $project->id,
    ]);

    expect($settlement->project)->toBeInstanceOf(Project::class);
    expect($settlement->project->id)->toBe($project->id);
});

test('a settlement can be linked to a phase via morphTo', function () {
    $phase = Phase::factory()->create();
    $settlement = Settlement::factory()->create([
        'model_type' => Phase::class,
        'model_id' => $phase->id,
    ]);

    expect($settlement->linkable)->toBeInstanceOf(Phase::class);
    expect($settlement->linkable->id)->toBe($phase->id);
});

test('a settlement has numeric importo attribute', function () {
    $settlement = Settlement::factory()->create([
        'importo' => '2500.75',
    ]);

    expect($settlement->importo)->toBe('2500.75');
});
