<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\View;

use Modules\Xot\Actions\View\GetViewByClassAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\View;

uses(TestCase::class);

it('converts class names to view names correctly', function (): void {
    $action = app(GetViewByClassAction::class);
    
    // Mock view existence
    View::addNamespace('user', sys_get_temp_dir());
    View::shouldReceive('exists')
        ->with('user::filament.resources.user-resource')
        ->andReturn(true);

    $class = 'Modules\\User\\Filament\\Resources\\UserResource';
    $result = $action->execute($class);
    
    expect($result)->toBe('user::filament.resources.user-resource');
});

it('handles singular previous parts correctly', function (): void {
    $action = app(GetViewByClassAction::class);
    
    // Test checkPrev logic directly
    // "UserResource" with previous "Resources" (singular "Resource")
    expect($action->checkPrev('UserResource', 'Resources'))->toBe('User');
    expect($action->checkPrev('NoMatch', 'Items'))->toBe('NoMatch');
});

it('throws exception when view is not found', function (): void {
    $action = app(GetViewByClassAction::class);
    
    View::shouldReceive('exists')->andReturn(false);
    
    expect(fn() => $action->execute('Modules\\Xot\\SomeClass'))->toThrow(\Exception::class);
});
