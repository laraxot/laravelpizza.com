<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Settlement;

uses(TestCase::class);

test('it can create a phase', function () {
    $phase = Phase::factory()->create([
        'name' => 'Phase 1',
        'description' => 'Test Phase',
    ]);

    expect($phase->name)->toBe('Phase 1')
        ->and($phase->description)->toBe('Test Phase');

    $this->assertDatabaseHas('phases', [
        'id' => $phase->id,
        'name' => 'Phase 1',
    ], 'incentivi');
});

test('a phase belongs to a project', function () {
    $project = Project::factory()->create();
    $phase = Phase::factory()->create([
        'project_id' => $project->id,
    ]);

    expect($phase->project)->toBeInstanceOf(Project::class);
    expect($phase->project->id)->toBe($project->id);
});

test('a phase has one settlement via morphOne', function () {
    $phase = Phase::factory()->create();
    $settlement = Settlement::factory()->create([
        'model_type' => Phase::class,
        'model_id' => $phase->id,
    ]);

    expect($phase->settlement)->toBeInstanceOf(Settlement::class);
    expect($phase->settlement->id)->toBe($settlement->id);
});

test('a phase has string id cast', function () {
    $phase = Phase::factory()->create();

    expect($phase->id)->toBeString();
});
