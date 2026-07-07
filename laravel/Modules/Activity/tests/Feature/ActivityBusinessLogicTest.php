<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\json_decode;
use function Safe\json_encode;

uses(\Modules\Activity\Tests\TestCase::class);

test('Activity Business Logic', function () {
    test('can create activity with basic information', function () {
        $activityData = [
            'log_name' => 'default',
            'description' => 'User logged in',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 123,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 123,
            'properties' => json_encode([
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'login_method' => 'email',
            ]),
            'event' => 'created',
            'batch_uuid' => Str::uuid()->toString(),
        ];

        $activity = Activity::create($activityData);

        Assert::assertInstanceOf(Activity::class, $activity);
        Assert::assertSame('default', $activity->log_name);
        Assert::assertSame('User logged in', $activity->description);
        Assert::assertSame('Modules\User\Models\User', $activity->subject_type);
        Assert::assertSame(123, $activity->subject_id);
        Assert::assertSame('created', $activity->event);
    });

    test('can track user authentication activities', function () {
        $loginActivity = Activity::create([
            'log_name' => 'auth',
            'description' => 'User logged in successfully',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 456,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 456,
            'properties' => json_encode([
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Chrome/91.0.4472.124',
                'login_time' => now()->toISOString(),
            ]),
            'event' => 'login',
        ]);

        $logoutActivity = Activity::create([
            'log_name' => 'auth',
            'description' => 'User logged out',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 456,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 456,
            'properties' => json_encode([
                'ip_address' => '192.168.1.100',
                'session_duration' => 3600,
                'logout_time' => now()->toISOString(),
            ]),
            'event' => 'logout',
        ]);

        Assert::assertSame('login', $loginActivity->event);
        Assert::assertSame('logout', $logoutActivity->event);
        Assert::assertSame('auth', $loginActivity->log_name);
        Assert::assertSame('auth', $logoutActivity->log_name);
    });

    test('can track model crud activities', function () {
        $createActivity = Activity::create([
            'log_name' => 'models',
            'description' => 'User created',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 789,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 1,
            'properties' => json_encode([
                'old' => null,
                'attributes' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ],
            ]),
            'event' => 'created',
        ]);

        $updateActivity = Activity::create([
            'log_name' => 'models',
            'description' => 'User updated',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 789,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 1,
            'properties' => json_encode([
                'old' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ],
                'attributes' => [
                    'name' => 'John Smith',
                    'email' => 'john.smith@example.com',
                ],
            ]),
            'event' => 'updated',
        ]);

        Assert::assertSame('created', $createActivity->event);
        Assert::assertSame('updated', $updateActivity->event);
        Assert::assertSame(789, $createActivity->subject_id);
        Assert::assertSame(789, $updateActivity->subject_id);
    });

    test('can use batch uuid for grouping activities', function () {
        $batchUuid = Str::uuid()->toString();

        $activity1 = Activity::create([
            'log_name' => 'batch',
            'description' => 'Batch operation started',
            'subject_type' => 'App\Models\Import',
            'subject_id' => 404,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 505,
            'properties' => json_encode(['step' => 'start']),
            'event' => 'batch_started',
            'batch_uuid' => $batchUuid,
        ]);

        $activity2 = Activity::create([
            'log_name' => 'batch',
            'description' => 'Batch operation completed',
            'subject_type' => 'App\Models\Import',
            'subject_id' => 404,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 505,
            'properties' => json_encode(['step' => 'complete', 'records_processed' => 1000]),
            'event' => 'batch_completed',
            'batch_uuid' => $batchUuid,
        ]);

        $activity1->batch_uuid = $batchUuid;
        $activity1->save();
        $activity2->batch_uuid = $batchUuid;
        $activity2->save();

        $activity1->refresh();
        $activity2->refresh();

        Assert::assertSame($batchUuid, $activity1->batch_uuid);
        Assert::assertSame($batchUuid, $activity2->batch_uuid);

        $batchActivities = Activity::where('batch_uuid', $batchUuid)->get();
        Assert::assertCount(2, $batchActivities);
    });

    test('can filter activities by log name', function () {
        $authActivity = Activity::create([
            'log_name' => 'auth',
            'description' => 'Login activity',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 606,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 606,
            'properties' => json_encode([]),
            'event' => 'login',
        ]);

        $modelActivity = Activity::create([
            'log_name' => 'models',
            'description' => 'Model activity',
            'subject_type' => 'Modules\User\Models\User',
            'subject_id' => 606,
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => 606,
            'properties' => json_encode([]),
            'event' => 'created',
        ]);

        $authActivities = Activity::where('log_name', 'auth')->get();
        $modelActivities = Activity::where('log_name', 'models')->get();

        /** @var Activity|null $firstAuthActivity */
        $firstAuthActivity = $authActivities->first();
        /** @var Activity|null $firstModelActivity */
        $firstModelActivity = $modelActivities->first();

        Assert::assertGreaterThanOrEqual(1, $authActivities->count());
        Assert::assertGreaterThanOrEqual(1, $modelActivities->count());

        // Ensure the activities created in this test are present in filtered results.
        Assert::assertTrue($authActivities->contains('id', $authActivity->id));
        Assert::assertTrue($modelActivities->contains('id', $modelActivity->id));

        Assert::assertNotNull($firstAuthActivity);
        Assert::assertNotNull($firstModelActivity);

        // Type narrowing assertions
        Assert::assertInstanceOf(Activity::class, $firstAuthActivity);
        Assert::assertInstanceOf(Activity::class, $firstModelActivity);
        Assert::assertSame('auth', $firstAuthActivity->log_name);
        Assert::assertSame('models', $firstModelActivity->log_name);
    });

    test('can handle activity with complex properties', function () {
        /** @var Activity $complexActivity */
        $complexActivity = Activity::create([
            'log_name' => 'complex',
            'description' => 'Complex operation with nested data',
            'subject_type' => 'App\\Models\\Order',
            'subject_id' => 909,
            'causer_type' => 'Modules\\User\\Models\\User',
            'causer_id' => 1010,
            'properties' => [
                'order_details' => [
                    'items' => [
                        ['id' => 1, 'name' => 'Product A', 'quantity' => 2, 'price' => 25.99],
                        ['id' => 2, 'name' => 'Product B', 'quantity' => 1, 'price' => 15.50],
                    ],
                    'total_amount' => 67.48,
                    'currency' => 'EUR',
                ],
                'customer_info' => [
                    'name' => 'Jane Smith',
                    'email' => 'jane@example.com',
                ],
            ],
            'event' => 'order_placed',
        ]);
        Assert::assertNotNull($complexActivity);

        $propertiesValue = $complexActivity->properties;
        /** @var array<string, mixed> $properties */
        $properties = [];
        if (is_string($propertiesValue)) {
            $decoded = json_decode($propertiesValue, true);
            $properties = is_array($decoded) ? $decoded : [];
        } elseif (is_array($propertiesValue)) {
            $properties = $propertiesValue;
        } elseif ($propertiesValue !== null && method_exists($propertiesValue, 'toArray')) {
            $properties = $propertiesValue->toArray();
        }

        Assert::assertIsArray($properties);
        Assert::assertTrue(isset($properties['order_details']));
        Assert::assertTrue(isset($properties['customer_info']));

        /** @var array<string, mixed> $orderDetails */
        $orderDetails = $properties['order_details'];
        /** @var array<string, mixed> $customerInfo */
        $customerInfo = $properties['customer_info'];

        Assert::assertIsArray($orderDetails);
        Assert::assertSame(67.48, $orderDetails['total_amount']);
    });
});
