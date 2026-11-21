<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Filament\Resources;

use Modules\Job\Filament\Resources\JobBatchResource;
use Modules\Job\Filament\Resources\JobBatchResource\Tables\JobBatchesTable;
use Modules\Job\Filament\Resources\JobsWaitingResource;
use Modules\Job\Filament\Resources\JobsWaitingResource\Tables\JobsWaitingsTable;
use Modules\Job\Models\JobBatch;
use Modules\Job\Models\JobsWaiting;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

/**
 * Guard test — evita la regressione descritta in
 * `docs/stories/xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`
 * (root): `JobsWaitingResource::$model` puntava a `Job::class` invece di
 * `JobsWaiting::class`, rendendo `JobsWaitingsTable` e `JobsWaitingPolicy`
 * irraggiungibili per convenzione (`XotBaseResource::getModel()`/`getTableClass()`).
 */
uses(TestCase::class)->group('no-job-db');

describe('JobsWaitingResource risolve JobsWaiting, non Job', function (): void {
    test('getModel() ritorna JobsWaiting::class', function (): void {
        Assert::assertSame(JobsWaiting::class, JobsWaitingResource::getModel());
    });

    test('getTableClass() risolve JobsWaitingsTable, non JobsTable', function (): void {
        Assert::assertSame(JobsWaitingsTable::class, JobsWaitingResource::getTableClass());
    });
});

describe('JobBatchResource risolve JobBatch per convenzione ($model commentato)', function (): void {
    test('getModel() ritorna JobBatch::class', function (): void {
        Assert::assertSame(JobBatch::class, JobBatchResource::getModel());
    });

    test('getTableClass() risolve JobBatchesTable, non il typo JobBatchsTable', function (): void {
        Assert::assertSame(JobBatchesTable::class, JobBatchResource::getTableClass());
    });
});
