<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('LogActivityAction', function () {
    it('can log a simple activity', function () {
        $action = app(LogActivityAction::class);
        $activity = $action->execute('test_type');

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->log_name)->toBe('test_type');
        expect($activity->description)->toBe('Activity: test_type');
    });

    it('can log activity with user', function () {
        $user = User::factory()->create();
        $action = app(LogActivityAction::class);
        $activity = $action->execute('user_action', $user);

        expect($activity->causer_id)->toBe($user->id);
        expect($activity->causer_type)->toBe(User::class);
    });

    it('can log activity with subject and properties', function () {
        $user = User::factory()->create();
        $subject = User::factory()->create();
        $properties = ['key' => 'value'];
        
        $action = app(LogActivityAction::class);
        $activity = $action->execute(
            type: 'subject_action',
            user: $user,
            subject: $subject,
            properties: $properties,
            description: 'Custom description'
        );

        expect($activity->subject_id)->toBe($subject->id);
        expect($activity->subject_type)->toBe(User::class);
        expect($activity->properties)->toBe($properties);
        expect($activity->description)->toBe('Custom description');
    });

    it('throws exception if type is empty', function () {
        $action = app(LogActivityAction::class);
        $action->execute('');
    })->throws(\InvalidArgumentException::class, 'Type cannot be empty');
});
