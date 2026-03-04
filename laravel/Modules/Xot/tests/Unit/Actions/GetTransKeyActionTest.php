<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetTransKeyAction;
use Tests\TestCase;

uses(TestCase::class);

test('get trans key action returns correct keys', function () {
    $action = app(GetTransKeyAction::class);

    // Test direct module class
    $key = $action->execute('Modules\User\Filament\Resources\UserResource');
    expect($key)->toBe('user::user');

    // Test with "List" prefix
    $key = $action->execute('Modules\User\Filament\Resources\UserResource\Pages\ListUsers');
    expect($key)->toBe('user::user');

    // Test with RelationManager
    $key = $action->execute('Modules\User\Filament\Resources\UserResource\RelationManagers\ProfilesRelationManager');
    expect($key)->toBe('user::profile');

    // Test with Action suffix
    $key = $action->execute('Modules\Activity\Actions\LogActivityAction');
    expect($key)->toBe('activity::log_activity');
});
