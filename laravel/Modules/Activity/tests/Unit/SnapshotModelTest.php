<?php

declare(strict_types=1);

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('snapshot getConnectionName returns string', function (): void {
    $model = new Snapshot();
    $connection = $model->getConnectionName();

    expect($connection)->toBeString()->not->toBeEmpty();
});

test('snapshot connection is activity in non-testing environment', function (): void {
    $model = new Snapshot();

    // When app env is NOT 'testing', model uses its declared connection
    if (! app()->environment('testing')) {
        expect($model->getConnectionName())->toBe('activity');
    } else {
        // In testing env, model uses config('database.default')
        $default = config('database.default');
        expect($model->getConnectionName())->toBe(is_string($default) ? $default : 'mysql');
    }
});
