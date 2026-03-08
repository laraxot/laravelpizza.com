<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

describe('ActivityLogger', function (): void {
    it('logs activity with auth fallback and default description', function (): void {
        $user = User::factory()->create();
        // @var mixed actingAs($user;

        $activity = app(ActivityLogger::class)->log(type: 'fallback-auth');

        expect($activity->event)->toBe('fallback-auth')
            ->and($activity->description)->toBe('fallback-auth')
            ->and($activity->causer_id)->toBe($user->id);
    });

    it('throws for invalid user type', function (): void {
        expect(fn (): Activity => app(ActivityLogger::class)->log(type: 'x', user: 'bad-user'))
            ->toThrow(InvalidArgumentException::class, 'User must be an instance of User');
    });

    it('returns user activities with limit and validates limit', function (): void {
        $user = User::factory()->create();
        $other = User::factory()->create();

        app(ActivityLogger::class)->log(type: 'a', user: $user);
        app(ActivityLogger::class)->log(type: 'b', user: $user);
        app(ActivityLogger::class)->log(type: 'c', user: $other);

        $items = app(ActivityLogger::class)->getUserActivities($user, 2);
        expect($items)->toHaveCount(2);

        expect(fn (): \Illuminate\Database\Eloquent\Collection => app(ActivityLogger::class)->getUserActivities($user, 0))
            ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
    });

    it('returns model activities', function (): void {
        $user = User::factory()->create();
        $subject = User::factory()->create();

        app(ActivityLogger::class)->log(type: 'model-event', user: $user, subject: $subject);
        app(ActivityLogger::class)->log(type: 'other-event', user: $user);

        $items = app(ActivityLogger::class)->getModelActivities($subject, 10);

        expect($items)->toHaveCount(1)
            ->and($items->first()?->subject_id)->toBe($subject->id);
    });

    it('filters by type and validates args', function (): void {
        $user = User::factory()->create();
        app(ActivityLogger::class)->log(type: 'filter-me', user: $user);
        app(ActivityLogger::class)->log(type: 'skip-me', user: $user);

        $items = app(ActivityLogger::class)->getByType('filter-me', 5);
        expect($items->pluck('event')->all())->toBe(['filter-me']);

        expect(fn (): \Illuminate\Database\Eloquent\Collection => app(ActivityLogger::class)->getByType('', 5))
            ->toThrow(InvalidArgumentException::class, 'Type cannot be empty');

        expect(fn (): \Illuminate\Database\Eloquent\Collection => app(ActivityLogger::class)->getByType('x', 0))
            ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
    });

    it('returns recent activities and validates limit', function (): void {
        $user = User::factory()->create();
        app(ActivityLogger::class)->log(type: 'recent-1', user: $user);
        app(ActivityLogger::class)->log(type: 'recent-2', user: $user);

        $recent = app(ActivityLogger::class)->getRecent(1);
        expect($recent)->toHaveCount(1);

        expect(fn (): \Illuminate\Database\Eloquent\Collection => app(ActivityLogger::class)->getRecent(0))
            ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
    });

    it('cleans old activities and validates days', function (): void {
        $user = User::factory()->create();
        $logger = app(ActivityLogger::class);

        CarbonImmutable::setTestNow('2026-03-05 10:00:00');
        $logger->log(type: 'old', user: $user);
        $old = Activity::query()->latest('id')->firstOrFail();
        $old->created_at = now()->subDays(120);
        $old->save();

        $logger->log(type: 'new', user: $user);

        $deleted = $logger->cleanOld(90);
        expect($deleted)->toBeGreaterThanOrEqual(1);

        expect(fn (): int => $logger->cleanOld(0))
            ->toThrow(InvalidArgumentException::class, 'Days must be positive');

        CarbonImmutable::setTestNow();
    });

    it('returns statistics globally and for a specific user', function (): void {
        $alice = User::factory()->create();
        $bob = User::factory()->create();
        $logger = app(ActivityLogger::class);

        $logger->log(type: 'alpha', user: $alice);
        $logger->log(type: 'alpha', user: $alice);
        $logger->log(type: 'beta', user: $bob);

        $global = $logger->getStatistics();
        expect($global['total'])->toBeGreaterThanOrEqual(3)
            ->and($global['by_type'])->toHaveKey('alpha')
            ->and($global['by_type'])->toHaveKey('beta');

        $aliceStats = $logger->getStatistics($alice);
        expect($aliceStats['by_type'])->toHaveKey('alpha')
            ->and($aliceStats['by_type'])->not->toHaveKey('beta');
    });

    it('logs custom event using provided description', function (): void {
        $subject = User::factory()->create();
        $logger = app(ActivityLogger::class);

        $activity = $logger->custom(
            type: 'custom-action',
            description: 'Custom event description',
            subject: $subject,
            properties: ['source' => 'test']
        );

        expect($activity->event)->toBe('custom-action')
            ->and($activity->description)->toBe('Custom event description')
            ->and($activity->subject_id)->toBe($subject->id);
    });

    it('ignores null event buckets in by_type statistics', function (): void {
        $user = User::factory()->create();
        $logger = app(ActivityLogger::class);

        $logger->log(type: 'valid-event', user: $user);

        Activity::query()->create([
            'log_name' => 'default',
            'description' => 'nullable event row',
            'causer_type' => User::class,
            'causer_id' => $user->id,
            'event' => null,
        ]);

        $stats = $logger->getStatistics();

        expect($stats['by_type'])->toHaveKey('valid-event')
            ->and($stats['by_type'])->not->toHaveKey('');
    });
});
