<?php

declare(strict_types=1);

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

uses(\Tests\TestCase::class, \Modules\Xot\Tests\CreatesApplication::class);

test('logout action logs out user and regenerates session', function (): void {
    // Arrange
    Auth::shouldReceive('guard')->with('web')->andReturnSelf();
    Auth::shouldReceive('logout')->once();

    Session::shouldReceive('invalidate')->once();
    Session::shouldReceive('regenerateToken')->once();

    $logout = new Logout();

    // Act
    $result = $logout();

    // Assert
    expect($result)->toBeInstanceOf(\Illuminate\Http\RedirectResponse::class);
    expect($result->getTargetUrl())->toContain('/');
});

test('logout action can be invoked', function (): void {
    Auth::shouldReceive('guard')->with('web')->andReturnSelf();
    Auth::shouldReceive('logout')->once();

    Session::shouldReceive('invalidate')->once();
    Session::shouldReceive('regenerateToken')->once();

    $logout = new Logout();
    $logout();
});
