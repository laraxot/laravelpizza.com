<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Tests\Fixtures\LogModelUpdatedActionTestModel;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogModelUpdatedAction execute persiste updated con subject e causer', function (): void {
    $model = new LogModelUpdatedActionTestModel;
    $model->forceFill(['id' => 'updated-1', 'name' => 'Updated']);
    $model->exists = true;
    $model->syncOriginal();

    $user = new User;
    $user->forceFill([
        'id' => 'causer-updated-1',
        'name' => 'Causer',
        'email' => 'causer-updated-1@example.test',
    ]);
    $user->exists = true;

    $activity = (new LogModelUpdatedAction($model, $user))->execute();

    Assert::assertSame('updated', $activity->event);
    Assert::assertSame($model::class, $activity->subject_type);

    $subjectKey = $model->getKey();
    Assert::assertIsString($subjectKey);
    Assert::assertIsString($activity->subject_id);
    Assert::assertSame($subjectKey, $activity->subject_id);
    Assert::assertSame($user->id, $activity->causer_id);
});
