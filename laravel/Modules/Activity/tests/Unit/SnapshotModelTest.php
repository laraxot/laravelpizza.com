<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('snapshot uses default db connection while testing', function (): void {
    $model = new Snapshot;

    expect($model->getConnectionName())->toBe((string) config('database.default'));
});

test('snapshot returns activity connection outside testing env', function (): void {
    $model = new Snapshot;

    $app = app();
    $originalEnv = $app['env'];

    try {
        $app->instance('env', 'local');

        expect($model->getConnectionName())->toBe('activity');
    } finally {
        $app->instance('env', $originalEnv);
    }
});
