<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Exception;
use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Tests\Fixtures\RestoreActivityEmptyModel;
use Modules\Activity\Tests\Fixtures\RestoreActivityFailingUpdateModel;
use Modules\Activity\Tests\Fixtures\RestoreActivityRecordingModel;
use Modules\Activity\Tests\TestCase;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

uses(TestCase::class);

test('RestoreActivityAction aggiorna il record con le vecchie proprietà', function (): void {
    $model = new RestoreActivityRecordingModel;

    (new RestoreActivityAction)->execute($model, ['name' => 'Ripristinato', 'status' => 'active']);

    expect($model->updatedAttributes)->toBe(['name' => 'Ripristinato', 'status' => 'active']);
});

test('RestoreActivityAction incapsula eccezioni di update', function (): void {
    $model = new RestoreActivityFailingUpdateModel;

    expect(function () use ($model): void {
        (new RestoreActivityAction)->execute($model, ['name' => 'x']);
    })->toThrow(Exception::class);
});

test('RestoreActivityAction rifiuta oldProperties vuote', function (): void {
    $model = new RestoreActivityEmptyModel;

    expect(function () use ($model): void {
        (new RestoreActivityAction)->execute($model, []);
    })->toThrow(AssertInvalidArgumentException::class);
});
