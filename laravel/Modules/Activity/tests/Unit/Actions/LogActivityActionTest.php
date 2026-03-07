<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Modules\Xot\Models\XotBaseModel;
use Tests\TestCase;

uses(TestCase::class);

describe('Activity Logging Actions', function () {
    
    it('can log a simple activity via LogActivityAction', function () {
        $action = app(LogActivityAction::class);
        $activity = $action->execute('test_type');

        expect($activity)->toBeInstanceOf(Activity::class);
        expect($activity->log_name)->toBe('test_type');
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
        expect($activity->properties->toArray())->toBe($properties);
        expect($activity->description)->toBe('Custom description');
    });

    it('can log user login via LogUserLoginAction', function () {
        $user = User::factory()->create(['name' => 'Mario Rossi']);
        $action = app(LogUserLoginAction::class);
        
        $activity = $action->execute($user);

        expect($activity->log_name)->toBe('login');
        expect($activity->causer_id)->toBe($user->id);
        expect($activity->description)->toContain('Mario Rossi logged in');
        expect($activity->properties)->toHaveKey('ip');
    });

    it('throws exception if LogActivityAction type is empty', function () {
        $action = app(LogActivityAction::class);
        $action->execute('');
    })->throws(\InvalidArgumentException::class, 'Type cannot be empty');

    it('throws exception if user model is not a User instance', function () {
        $action = app(LogActivityAction::class);

        $notUser = new class extends XotBaseModel {
            protected $table = 'activities';
        };

        expect(fn () => $action->execute(type: 'bad-user', user: $notUser))
            ->toThrow(\InvalidArgumentException::class, 'User must be an instance of User');
    });
});
