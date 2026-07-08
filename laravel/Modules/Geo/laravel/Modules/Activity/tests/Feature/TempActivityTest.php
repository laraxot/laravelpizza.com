<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Collection;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('can create activity with basic information', function () {
    $user = UserFactory::new()->createOne();
    $activity = Activity::create([
        'log_name' => 'default',
        'description' => 'User logged in',
        'subject_type' => $user::class,
        'subject_id' => $user->id,
        'causer_type' => $user::class,
        'causer_id' => $user->id,
        'event' => 'logged_in',
        'properties' => ['ip_address' => '127.0.0.1'],
    ]);
    $properties = $activity->properties;
    Assert::assertNotNull($properties);
    Assert::assertInstanceOf(SchemalessAttributes::class, $properties);
    $propertiesArray = $properties->toArray();

    Assert::assertSame('default', $activity->log_name);
    Assert::assertSame('User logged in', $activity->description);
    Assert::assertSame($user::class, $activity->subject_type);
    Assert::assertSame($user->id, $activity->subject_id);
    Assert::assertSame($user::class, $activity->causer_type);
    Assert::assertSame($user->id, $activity->causer_id);
    Assert::assertSame('logged_in', $activity->event);
    Assert::assertSame(['ip_address' => '127.0.0.1'], $propertiesArray);
});
