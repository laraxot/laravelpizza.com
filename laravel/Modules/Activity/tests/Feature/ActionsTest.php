<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\Fixtures\LogActivityActionTestModel;
use Modules\Activity\Tests\Fixtures\LogModelCreatedActionTestModel;
use Modules\Activity\Tests\Fixtures\LogModelDeletedActionTestModel;
use Modules\Activity\Tests\Fixtures\LogModelUpdatedActionTestModel;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

describe('ActivityLogger', function (): void {
    it('logs activity with user provided', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        /** @var Activity $activity */
        $activity = $logger->log('test_event', $this->user, $model, ['key' => 'value'], 'Test description');

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->description)->toBe('Test description');
        expect($activity->event)->toBe('test_event');
        expect($activity->causer_type)->toBe(User::class);
        expect($activity->causer_id)->toBe($this->user->id);
        expect($activity->subject_type)->toBe(LogActivityActionTestModel::class);
        expect($activity->properties->toArray())->toBe(['key' => 'value']);
    });

    it('logs activity without user uses auth', function (): void {
        $this->actingAs($this->user);
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        /** @var Activity $activity */
        $activity = $logger->log('test_event', null, $model);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->causer_id)->toBe($this->user->id);
    });

    it('throws exception for invalid user type', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        expect(fn () => $logger->log('test_event', 'invalid_user', $model))
            ->toThrow(InvalidArgumentException::class, 'User must be an instance of User');
    });

    it('logs created event', function (): void {
        $logger = new ActivityLogger();
        $model = new LogModelCreatedActionTestModel(['name' => 'Created Model']);

        /** @var Activity $activity */
        $activity = $logger->created($model, $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('created');
        expect($activity->description)->toContain('created');
    });

    it('logs updated event', function (): void {
        $logger = new ActivityLogger();
        $model = new LogModelUpdatedActionTestModel(['name' => 'Updated Model']);
        $model->name = 'New Name';
        $model->save();

        /** @var Activity $activity */
        $activity = $logger->updated($model, $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('updated');
        expect($activity->description)->toContain('updated');
    });

    it('logs deleted event', function (): void {
        $logger = new ActivityLogger();
        $model = new LogModelDeletedActionTestModel(['name' => 'Deleted Model']);
        $model->save();

        /** @var Activity $activity */
        $activity = $logger->deleted($model, $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('deleted');
        expect($activity->description)->toContain('deleted');
    });

    it('logs login event', function (): void {
        $logger = new ActivityLogger();

        /** @var Activity $activity */
        $activity = $logger->login($this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('login');
        expect($activity->description)->toBe('User logged in');
    });

    it('logs logout event', function (): void {
        $logger = new ActivityLogger();

        /** @var Activity $activity */
        $activity = $logger->logout($this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('logout');
        expect($activity->description)->toBe('User logged out');
    });

    it('logs custom event', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        /** @var Activity $activity */
        $activity = $logger->custom('custom_type', 'Custom description', $model, ['custom' => 'data']);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('custom_type');
        expect($activity->description)->toBe('Custom description');
        expect($activity->properties->toArray())->toBe(['custom' => 'data']);
    });

    it('gets user activities', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $logger->log('test_event', $this->user, $model);
        $logger->log('test_event_2', $this->user, $model);

        $activities = $logger->getUserActivities($this->user, 10);

        expect($activities)->toHaveCount(2);
    });

    it('throws exception for invalid limit in getUserActivities', function (): void {
        $logger = new ActivityLogger();

        expect(fn () => $logger->getUserActivities($this->user, 0))
            ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
    });

    it('gets model activities', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);
        $model->save();

        $logger->log('test_event', $this->user, $model);

        $activities = $logger->getModelActivities($model, 10);

        expect($activities)->toHaveCount(1);
    });

    it('gets activities by type', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $logger->log('specific_type', $this->user, $model);
        $logger->log('other_type', $this->user, $model);

        $activities = $logger->getByType('specific_type', 10);

        expect($activities)->toHaveCount(1);
        expect($activities->first()->event)->toBe('specific_type');
    });

    it('throws exception for empty type in getByType', function (): void {
        $logger = new ActivityLogger();

        expect(fn () => $logger->getByType('', 10))
            ->toThrow(InvalidArgumentException::class, 'Type cannot be empty');
    });

    it('throws exception for invalid limit in getByType', function (): void {
        $logger = new ActivityLogger();

        expect(fn () => $logger->getByType('test', 0))
            ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
    });

    it('gets recent activities', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $logger->log('test_event', $this->user, $model);

        $activities = $logger->getRecent(10);

        expect($activities)->toHaveCount(1);
    });

    it('throws exception for invalid limit in getRecent', function (): void {
        $logger = new ActivityLogger();

        expect(fn () => $logger->getRecent(0))
            ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
    });

    it('cleans old activities', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $logger->log('test_event', $this->user, $model);

        // Use a future date so nothing gets deleted
        $deletedCount = $logger->cleanOld(365);

        expect($deletedCount)->toBe(0);
    });

    it('throws exception for invalid days in cleanOld', function (): void {
        $logger = new ActivityLogger();

        expect(fn () => $logger->cleanOld(0))
            ->toThrow(InvalidArgumentException::class, 'Days must be positive');
    });

    it('gets statistics without user', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $logger->log('test_event', $this->user, $model);

        $stats = $logger->getStatistics();

        expect($stats)->toBeArray();
        expect($stats)->toHaveKeys(['total', 'by_type', 'today', 'this_week', 'this_month']);
        expect($stats['total'])->toBe(1);
    });

    it('gets statistics with user', function (): void {
        $logger = new ActivityLogger();
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $logger->log('test_event', $this->user, $model);

        $stats = $logger->getStatistics($this->user);

        expect($stats['total'])->toBe(1);
    });
});

describe('LogActivityAction', function (): void {
    it('creates activity with user', function (): void {
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $action = new LogActivityAction(
            type: 'test_type',
            user: $this->user,
            subject: $model,
            properties: ['test' => 'value'],
            description: 'Test description'
        );

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('test_type');
        expect($activity->description)->toBe('Test description');
    });

    it('creates activity without user uses auth', function (): void {
        $this->actingAs($this->user);
        $model = new LogActivityActionTestModel(['name' => 'Test Model']);

        $action = new LogActivityAction(
            type: 'test_type',
            user: null,
            subject: $model,
        );

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->causer_id)->toBe($this->user->id);
    });

    it('throws exception for empty type', function (): void {
        expect(fn () => new LogActivityAction(type: '', user: $this->user))
            ->toThrow(InvalidArgumentException::class, 'Type cannot be empty');
    });

    it('throws exception for invalid user type', function (): void {
        expect(fn () => new LogActivityAction(type: 'test', user: 'invalid'))
            ->toThrow(\TypeError::class);
    });
});

describe('LogModelCreatedAction', function (): void {
    it('logs model creation', function (): void {
        $model = new LogModelCreatedActionTestModel(['name' => 'Created Model']);

        $action = new LogModelCreatedAction(model: $model, user: $this->user);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('created');
        expect($activity->description)->toContain('LogModelCreatedActionTestModel');
    });

    it('logs model creation without user', function (): void {
        $model = new LogModelCreatedActionTestModel(['name' => 'Created Model']);

        $action = new LogModelCreatedAction(model: $model);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('created');
    });
});

describe('LogModelDeletedAction', function (): void {
    it('logs model deletion', function (): void {
        $model = new LogModelDeletedActionTestModel(['name' => 'Deleted Model']);

        $action = new LogModelDeletedAction(model: $model, user: $this->user);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('deleted');
        expect($activity->description)->toContain('LogModelDeletedActionTestModel');
    });

    it('logs model deletion without user', function (): void {
        $model = new LogModelDeletedActionTestModel(['name' => 'Deleted Model']);

        $action = new LogModelDeletedAction(model: $model);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('deleted');
    });
});

describe('LogModelUpdatedAction', function (): void {
    it('logs model update', function (): void {
        // Use the actual model's changes instead of saving
        $model = new LogModelUpdatedActionTestModel(['name' => 'Old Name']);
        // Manually set changes to simulate an update
        $model->name = 'New Name';
        // Simulate what getChanges() returns after a real update
        $model->syncOriginal();

        $action = new LogModelUpdatedAction(model: $model, user: $this->user);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('updated');
        expect($activity->description)->toContain('LogModelUpdatedActionTestModel');
    });

    it('logs model update without user', function (): void {
        $model = new LogModelUpdatedActionTestModel(['name' => 'Old Name']);
        $model->name = 'New Name';
        $model->syncOriginal();

        $action = new LogModelUpdatedAction(model: $model);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('updated');
    });
});

describe('LogUserLoginAction', function (): void {
    it('logs user login', function (): void {
        $action = new LogUserLoginAction(user: $this->user);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('login');
        expect($activity->description)->toBe('User logged in');
        expect($activity->subject_type)->toBe(User::class);
    });
});

describe('LogUserLogoutAction', function (): void {
    it('logs user logout', function (): void {
        $action = new LogUserLogoutAction(user: $this->user);

        /** @var Activity $activity */
        $activity = $action->execute();

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('logout');
        expect($activity->description)->toBe('User logged out');
        expect($activity->subject_type)->toBe(User::class);
    });
});

describe('RestoreActivityAction', function (): void {
    it('throws exception for empty properties', function (): void {
        $model = new LogModelUpdatedActionTestModel(['name' => 'Original Name']);

        $action = new RestoreActivityAction();

        expect(fn () => $action->execute($model, []))
            ->toThrow(\Webmozart\Assert\InvalidArgumentException::class, 'Old properties cannot be empty');
    });

    it('accepts non-empty properties', function (): void {
        $model = new LogModelUpdatedActionTestModel(['name' => 'Original Name']);
        $oldProperties = ['name' => 'Restored Name'];

        $action = new RestoreActivityAction();

        // Should not throw
        $action->execute($model, $oldProperties);
    });
});
