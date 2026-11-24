<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Tests\Fixtures\LogModelCreatedActionTestModel;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogModelCreatedAction execute persiste created con subject e causer', function (): void {
    $model = new LogModelCreatedActionTestModel;
    $model->forceFill(['id' => 'created-1', 'name' => 'Created']);
    $model->exists = true;

    $user = new User;
    $user->forceFill([
        'id' => 'causer-created-1',
        'name' => 'Causer',
        'email' => 'causer-created-1@example.test',
    ]);
    $user->exists = true;

    $activity = (new LogModelCreatedAction($model, $user))->execute();

    Assert::assertSame('created', $activity->event);
    Assert::assertSame($model::class, $activity->subject_type);
    Assert::assertSame($model->getKey(), $activity->subject_id);
    Assert::assertSame($user->id, $activity->causer_id);
});

test('LogModelCreatedAction execute accetta model passato a execute', function (): void {
    $model = new LogModelCreatedActionTestModel;
    $model->forceFill(['id' => 'created-2', 'name' => 'ViaExecute']);
    $model->exists = true;

    $activity = (new LogModelCreatedAction)->execute($model);

    Assert::assertSame('created', $activity->event);
    Assert::assertSame($model::class, $activity->subject_type);
});
