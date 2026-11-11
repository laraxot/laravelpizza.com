<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;
use Mockery\MockInterface;
use Modules\User\Models\Policies\UserPolicy;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

/*
 * Le azioni di riga sugli utenti (cambio password, verifica email, "deactivate") chiedono al Gate `update` o `delete`:
 * qui si fissa il verdetto che la policy da' loro, senza database e senza app (utenti Mockery con ruolo e id).
 * Il verdetto segue il Gate: se `before()` risponde, vale quello; altrimenti decide il metodo della policy.
 * Ogni verdetto usa una policy nuova perche' `before()` memorizza il risultato con `once()` per istanza.
 */

/**
 * @param  list<string>  $roles
 */
function userActionsActor(string $id, array $roles): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')->andReturnUsing(
        static fn (string|array $role): bool => array_filter(
            is_array($role) ? $role : [$role],
            static fn (mixed $name): bool => in_array($name, $roles, true)
        ) !== []
    );
    $user->shouldReceive('getAuthIdentifier')->andReturn($id);

    return $user;
}

/**
 * @param  list<string>  $roles
 */
function userActionsTarget(string $id, array $roles): User
{
    /** @var MockInterface&User $user */
    $user = Mockery::mock(User::class);
    $user->shouldReceive('hasRole')->andReturnUsing(
        static fn (string|array $role): bool => array_filter(
            is_array($role) ? $role : [$role],
            static fn (mixed $name): bool => in_array($name, $roles, true)
        ) !== []
    );
    $user->shouldReceive('getAuthIdentifier')->andReturn($id);

    return $user;
}

function userActionsAllows(UserContract $actor, string $ability, User $target): bool
{
    $policy = new UserPolicy;
    $before = $policy->before($actor, $ability, $target);
    if ($before !== null) {
        return $before;
    }

    return $policy->{$ability}($actor, $target) === true;
}

afterEach(function (): void {
    Mockery::close();
});

test('un amministratore di modulo cambia password, verifica email e cancella un utente ordinario', function (string $role, string $ability): void {
    $admin = userActionsActor('a1', [$role]);

    expect(userActionsAllows($admin, $ability, userActionsTarget('u2', [])))->toBeTrue();
})->with(['admin', 'user::admin'])->with(['update', 'delete']);

test('un amministratore di modulo non tocca un super-admin: non ne cambia la password e non lo cancella', function (string $role, string $ability): void {
    $admin = userActionsActor('a1', [$role]);

    expect(userActionsAllows($admin, $ability, userActionsTarget('root', ['super-admin'])))->toBeFalse();
})->with(['admin', 'user::admin'])->with(['update', 'delete']);

test('un amministratore di modulo non cancella se stesso', function (string $role): void {
    $admin = userActionsActor('a1', [$role]);

    expect(userActionsAllows($admin, 'delete', userActionsTarget('a1', [$role])))->toBeFalse();
})->with(['admin', 'user::admin']);

test('chi non amministra gli utenti non cambia la password e non cancella un altro utente', function (string $ability): void {
    $citizen = userActionsActor('c1', ['operator']);

    expect(userActionsAllows($citizen, $ability, userActionsTarget('u2', [])))->toBeFalse();
})->with(['update', 'delete']);

test('il super-admin agisce sugli altri, anche su un altro super-admin, ma non cancella se stesso', function (): void {
    $root = userActionsActor('root1', ['super-admin']);

    expect(userActionsAllows($root, 'update', userActionsTarget('u2', [])))->toBeTrue()
        ->and(userActionsAllows($root, 'update', userActionsTarget('root2', ['super-admin'])))->toBeTrue()
        ->and(userActionsAllows($root, 'delete', userActionsTarget('u2', [])))->toBeTrue()
        ->and(userActionsAllows($root, 'delete', userActionsTarget('root1', ['super-admin'])))->toBeFalse();
});
