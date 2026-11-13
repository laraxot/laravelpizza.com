<?php

declare(strict_types=1);
<<<<<<< .merge_file_yppdz3

=======
>>>>>>> .merge_file_KkRkur
use Modules\Activity\Actions\RedactModelAttributesAction;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
<<<<<<< .merge_file_yppdz3
use PHPUnit\Framework\Assert;

=======
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_KkRkur
uses()->group('no-activity-db');

describe('coverage senza database activity_log', function (): void {
    test('RedactModelAttributesAction rimuove chiavi sensibili', function (): void {
<<<<<<< .merge_file_yppdz3
        $action = new RedactModelAttributesAction();
=======
        $action = new RedactModelAttributesAction;
>>>>>>> .merge_file_KkRkur

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

    test('modelli event-sourcing usano connection activity', function (): void {
<<<<<<< .merge_file_yppdz3
        Assert::assertSame('activity', (new Activity())->getConnectionName());
        Assert::assertSame('activity', (new Snapshot())->getConnectionName());
        Assert::assertSame('activity', (new StoredEvent())->getConnectionName());
=======
        Assert::assertSame('activity', (new Activity)->getConnectionName());
        Assert::assertSame('activity', (new Snapshot)->getConnectionName());
        Assert::assertSame('activity', (new StoredEvent)->getConnectionName());
>>>>>>> .merge_file_KkRkur
    });
});
