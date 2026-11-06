<?php

declare(strict_types=1);
use Illuminate\Contracts\Auth\Authenticatable;
use Mockery\MockInterface;
use Modules\Activity\Actions\Log\AuthorizeLogAccessAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Tests\TestCase;

uses(TestCase::class);

/*
 * Gli utenti sono mock (nessuna riga nel database): la regola dipende solo da hasRole()/hasPermissionTo().
 */
function mockLogUser(bool $isSuperAdmin, bool|Throwable $hasPermission = false): UserContract&Authenticatable
{
    /** @var MockInterface&UserContract&Authenticatable $user */
    $user = Mockery::mock(UserContract::class, Authenticatable::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);
    $expectation = $user->shouldReceive('hasPermissionTo')->with('log.viewAny');

    if ($hasPermission instanceof Throwable) {
        $expectation->andThrow($hasPermission);
    } else {
        $expectation->andReturn($hasPermission);
    }

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

it('allows super-admins', function (): void {
    expect((new AuthorizeLogAccessAction)->execute(mockLogUser(true)))->toBeTrue();
});

it('allows users with the log.viewAny permission', function (): void {
    expect((new AuthorizeLogAccessAction)->execute(mockLogUser(false, true)))->toBeTrue();
});

it('denies users without the role and without the permission', function (): void {
    expect((new AuthorizeLogAccessAction)->execute(mockLogUser(false, false)))->toBeFalse();
});

it('denies access, without crashing, when the permission does not exist yet', function (): void {
    expect((new AuthorizeLogAccessAction)->execute(mockLogUser(false, new PermissionDoesNotExist)))->toBeFalse();
});

it('denies guests and users that do not implement the project user contract', function (): void {
    expect((new AuthorizeLogAccessAction)->execute(null))->toBeFalse();

    /** @var MockInterface&Authenticatable $genericUser */
    $genericUser = Mockery::mock(Authenticatable::class);
    expect((new AuthorizeLogAccessAction)->execute($genericUser))->toBeFalse();
});
