<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use Modules\User\Contracts\UserContract;
use Modules\User\Listeners\LogoutListener;
use Modules\User\Tests\TestCase;
use Modules\User\Tests\Unit\Models\Fixtures\TestBaseUser;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-user-db');

afterEach(function (): void {
    \Mockery::close();
});

/**
 * Logout con user tipizzato; null via reflection perché il PHPDoc del costruttore
 * non ammette null anche se handle() lo gestisce a runtime.
 */
function logoutEvent(?Authenticatable $user): Logout
{
    /** @var Authenticatable&MockInterface $placeholder */
    $placeholder = \Mockery::mock(Authenticatable::class);
    $event = new Logout('web', $placeholder);
    if ($user === null) {
        $prop = (new \ReflectionClass($event))->getProperty('user');
        $prop->setAccessible(true);
        $prop->setValue($event, null);
    } else {
        $event->user = $user;
    }

    return $event;
}

describe('LogoutListener behavior', function (): void {
    test('handle returns early when user is null', function (): void {
        Log::shouldReceive('warning')->once()->with('Tentativo di logout per un utente non autenticato');

        $listener = new LogoutListener(Request::create('/logout', 'POST'));
        $listener->handle(logoutEvent(null));

    });

    test('forgetRememberTokens no-ops for non UserContract', function (): void {
        /** @var Authenticatable&MockInterface $guest */
        $guest = \Mockery::mock(Authenticatable::class);
        $listener = new LogoutListener(Request::create('/'));
        $listener->forgetRememberTokens(logoutEvent($guest));

        Assert::assertFalse($guest instanceof UserContract);
    });

    test('forgetRememberTokens catches errors for BaseUser without DB', function (): void {
        Log::shouldReceive('error')->atLeast()->once();

        $user = new TestBaseUser;
        $user->forceFill(['id' => 'logout-user-1']);

        $listener = new LogoutListener(Request::create('/'));
        $listener->forgetRememberTokens(logoutEvent($user));

        Assert::assertSame('logout-user-1', $user->id);
    });
});
