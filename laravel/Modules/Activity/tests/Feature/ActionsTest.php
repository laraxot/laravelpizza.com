<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function createUser(): User
{
    return (new UserFactory)->createOne();
}

describe('ActivityLogger', function (): void {
    test('logs simple activity', function (): void {
        $user = createUser();
        $logger = new ActivityLogger;
        $activity = $logger->log('test_event', $user);

        Assert::assertSame('test_event', $activity->event);
        Assert::assertSame($user->id, $activity->causer_id);
    });

    test('logs created event', function (): void {
        $user = createUser();
        $logger = new ActivityLogger;
        $model = TestCase::activityCreateUser();

        $activity = $logger->created($model, $user);

        Assert::assertSame('created', $activity->event);
        Assert::assertSame($model->id, $activity->subject_id);
    });
});
