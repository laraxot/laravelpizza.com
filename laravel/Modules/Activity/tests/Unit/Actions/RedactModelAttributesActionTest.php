<?php

declare(strict_types=1);
use Modules\Activity\Actions\RedactModelAttributesAction;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-activity-db');

describe('coverage senza database activity_log', function (): void {
    test('RedactModelAttributesAction rimuove chiavi sensibili', function (): void {
        $action = new RedactModelAttributesAction;

        $redacted = $action->execute([
            'name' => 'Marco',
            'email' => 'a@b.it',
            'password' => 'secret',
            'remember_token' => 'tok',
            'two_factor_secret' => 'sec',
            'two_factor_recovery_codes' => ['x'],
        ]);

        Assert::assertSame(['name' => 'Marco', 'email' => 'a@b.it'], $redacted);
    });

    test('Activity espone connection e scopes SQL', function (): void {
        $batchUuid = 'batch-123';

        $forBatchSql = Activity::query()->forBatch($batchUuid)->toSql();
        $hasBatchSql = Activity::query()->hasBatch()->toSql();

        Assert::assertStringContainsString('batch_uuid', $forBatchSql);
        Assert::assertStringContainsString('not null', strtolower($hasBatchSql));
    });

    test('modelli event-sourcing usano la connessione di default in testing', function (): void {
        Assert::assertSame('activity', (new Activity)->getConnectionName());
        // Snapshot/StoredEvent forzano `database.default` quando APP_ENV=testing.
        Assert::assertSame(config('database.default'), (new Snapshot)->getConnectionName());
        Assert::assertSame(config('database.default'), (new StoredEvent)->getConnectionName());
    });
});
