<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

describe('ActivityLogger', function (): void {
    it('logs simple activity', function (): void {
        $logger = new ActivityLogger;
        $activity = $logger->log('test_event', $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('test_event');
        expect($activity->causer_id)->toBe($this->user->id);
    });

    it('logs created event', function (): void {
        $logger = new ActivityLogger;
        $model = User::factory()->create();

        $activity = $logger->created($model, $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('created');
        expect($activity->subject_id)->toBe($model->id);
    });

    it('logs updated event', function (): void {
        $logger = new ActivityLogger;
        $model = User::factory()->create();

        $activity = $logger->updated($model, $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('updated');
        expect($activity->subject_id)->toBe($model->id);
    });

    it('logs deleted event', function (): void {
        $logger = new ActivityLogger;
        $model = User::factory()->create();

        $activity = $logger->deleted($model, $this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('deleted');
        expect($activity->subject_id)->toBe($model->id);
    });

    it('logs login event', function (): void {
        $logger = new ActivityLogger;
        $activity = $logger->login($this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('login');
        expect($activity->description)->toContain('User Test User logged in');
    });

    it('logs logout event', function (): void {
        $logger = new ActivityLogger;
        $activity = $logger->logout($this->user);

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->event)->toBe('logout');
        expect($activity->description)->toContain('User Test User logged out');
    });
});

describe('LogActivityAction', function (): void {
    it('creates activity with user', function (): void {
        $action = app(LogActivityAction::class);
        $activity = $action->execute(
            type: 'test_type',
            user: $this->user,
            description: 'Test description'
        );

        expect($activity->log_name)->toBe('test_type');
        expect($activity->causer_id)->toBe($this->user->id);
    });
});

describe('LogModelCreatedAction', function (): void {
    it('logs model creation', function (): void {
        $model = User::factory()->create();
        $action = app(LogModelCreatedAction::class);

        $activity = $action->execute($model);

        expect($activity->event)->toBe('created');
        expect($activity->subject_id)->toBe($model->id);
    });
});
