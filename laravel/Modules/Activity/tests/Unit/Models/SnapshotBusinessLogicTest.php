<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use ReflectionClass;

uses(TestCase::class);

/*
 * Configurazione dichiarata del modello Snapshot (event sourcing Spatie).
 * La connessione effettiva in testing e' coperta da tests/Unit/SnapshotModelTest.
 */
describe('Snapshot Business Logic', function (): void {
    test('snapshot declares the activity connection outside testing', function (): void {
        $property = new ReflectionClass(Snapshot::class)->getProperty('connection');

        expect($property->getDefaultValue())->toBe('activity');
    });

    test('snapshot has expected fillable fields for event sourcing', function (): void {
        expect(new Snapshot()->getFillable())->toBe([
            'id',
            'aggregate_uuid',
            'aggregate_version',
            'state',
            'created_at',
            'updated_at',
        ]);
    });

    test('snapshot documents its persisted columns as property annotations', function (): void {
        $docComment = new ReflectionClass(Snapshot::class)->getDocComment();

        expect($docComment)->toBeString()
            ->toContain('@property string $aggregate_uuid')
            ->toContain('@property int $aggregate_version')
            ->toContain('$state');
    });
});
