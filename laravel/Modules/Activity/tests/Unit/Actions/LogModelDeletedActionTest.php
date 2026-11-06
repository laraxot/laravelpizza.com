<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogModelDeletedAction can execute for a model', function (): void {
    $model = UserFactory::new()->createOne();
    $action = new LogModelDeletedAction;
    $activity = $action->execute($model);

    Assert::assertSame($model->getKey(), $activity->subject_id);
});
