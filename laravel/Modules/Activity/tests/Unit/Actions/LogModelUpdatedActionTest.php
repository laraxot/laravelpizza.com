<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogModelUpdatedAction can execute for a model', function (): void {
    $model = UserFactory::new()->createOne();
    $action = new LogModelUpdatedAction;
    $activity = $action->execute($model);

    Assert::assertSame($model->getKey(), $activity->subject_id);
});
