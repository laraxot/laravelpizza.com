<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeAttributeCastAction;
use Modules\Xot\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

it('manages eloquent attributes safely', function (): void {
    $user = new User();
    $user->name = 'Test User';
    $user->email = '';
    $user->id = 123;
    
    $action = app(SafeAttributeCastAction::class);
    
    // hasAttribute
    expect($action->hasAttribute($user, 'name'))->toBeTrue();
    expect($action->hasAttribute($user, 'missing'))->toBeFalse();
    
    // hasNonEmptyAttribute
    expect($action->hasNonEmptyAttribute($user, 'name'))->toBeTrue();
    expect($action->hasNonEmptyAttribute($user, 'email'))->toBeFalse();
    
    // getStringAttribute
    expect($action->getStringAttribute($user, 'name'))->toBe('Test User');
    expect($action->getStringAttribute($user, 'missing', 'default'))->toBe('default');
    
    // getIntAttribute
    expect($action->getIntAttribute($user, 'id'))->toBe(123);
    
    // getBooleanAttribute (using 1 as true)
    $user->active = 1;
    expect($action->getBooleanAttribute($user, 'active'))->toBeTrue();
    
    // getTypedAttribute
    expect($action->getTypedAttribute($user, 'name', 'string'))->toBe('Test User');
    expect($action->getTypedAttribute($user, 'id', 'int'))->toBe(123);
    
    // hasAttributeValue
    expect($action->hasAttributeValue($user, 'id', 123))->toBeTrue();
    expect($action->hasAttributeValue($user, 'id', '123'))->toBeFalse();
    
    // getValidatedAttribute
    expect($action->getValidatedAttribute($user, 'id', 'int', fn($val) => $val > 100))->toBe(123);
    expect($action->getValidatedAttribute($user, 'id', 'int', fn($val) => $val > 200, 0))->toBe(0);
    
    // Static methods
    expect(SafeAttributeCastAction::hasNonEmpty($user, 'name'))->toBeTrue();
    expect(SafeAttributeCastAction::getString($user, 'name'))->toBe('Test User');
});
