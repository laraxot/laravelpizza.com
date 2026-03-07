<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

describe('Activity Lifecycle Actions', function () {
    
    it('can log model creation via LogModelCreatedAction', function () {
        $user = User::factory()->create(['name' => 'New User']);
        $action = app(LogModelCreatedAction::class);
        
        $activity = $action->execute($user);

        expect($activity->log_name)->toBe('created');
        expect($activity->subject_id)->toBe($user->id);
        expect($activity->description)->toContain('User was created');
        expect($activity->properties->toArray())->toHaveKey('name', 'New User');
    });

    it('can log model update via LogModelUpdatedAction', function () {
        $user = User::factory()->create(['name' => 'Old Name']);
        $user->name = 'New Name';
        // Note: in memory changes only for this test, as LogModelUpdatedAction uses getChanges()
        $user->syncChanges(); 
        
        $action = app(LogModelUpdatedAction::class);
        $activity = $action->execute($user);

        expect($activity->log_name)->toBe('updated');
        expect($activity->subject_id)->toBe($user->id);
        expect($activity->description)->toContain('User was updated');
    });

    it('can log model deletion via LogModelDeletedAction', function () {
        $user = User::factory()->create();
        $action = app(LogModelDeletedAction::class);
        
        $activity = $action->execute($user);

        expect($activity->log_name)->toBe('deleted');
        expect($activity->subject_id)->toBe($user->id);
        expect($activity->description)->toContain('User was deleted');
    });

    it('can log user logout via LogUserLogoutAction', function () {
        // First refactor LogUserLogoutAction
        $user = User::factory()->create(['name' => 'Logged Out User']);
        $action = app(\Modules\Activity\Actions\LogUserLogoutAction::class);
        
        $activity = $action->execute($user);

        expect($activity->log_name)->toBe('logout');
        expect($activity->causer_id)->toBe($user->id);
        expect($activity->description)->toContain('User Logged Out User logged out');
    });
});
