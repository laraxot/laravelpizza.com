<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Mockery\MockInterface;
use Modules\User\Models\Role;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

/*
 * Quali ruoli puo' assegnare chi opera dal pannello: il `super-admin` solo chi lo e' gia'.
 * Nessun database e nessuna app: operatori Mockery con i soli ruoli, builder Mockery al posto della query.
 */

function roleAssignableActor(string ...$roles): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->andReturnUsing(
        static fn (string|array $role): bool => array_filter(
            is_array($role) ? $role : [$role],
            static fn (mixed $name): bool => in_array($name, $roles, true)
        ) !== []
    );

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

test('il nome del ruolo super-admin e quello usato dalle policy e da canAccessPanel', function (): void {
    expect(Role::SUPER_ADMIN)->toBe('super-admin');
});

test('un ospite non assegna il super-admin', function (): void {
    expect(Role::mayAssignSuperAdmin(null))->toBeFalse();
});

test('un utente autenticato che non e UserContract non assegna il super-admin', function (): void {
    /** @var MockInterface&Authenticatable $actor */
    $actor = Mockery::mock(Authenticatable::class);

    expect(Role::mayAssignSuperAdmin($actor))->toBeFalse();
});

test('admin e user::admin non assegnano il super-admin', function (string ...$roles): void {
    expect(Role::mayAssignSuperAdmin(roleAssignableActor(...$roles)))->toBeFalse();
})->with([
    'admin' => ['admin'],
    'user::admin' => ['user::admin'],
    'admin di entrambi i tipi' => ['admin', 'user::admin'],
]);

test('chi non ha ruoli non assegna il super-admin', function (): void {
    expect(Role::mayAssignSuperAdmin(roleAssignableActor()))->toBeFalse();
});

test('un super-admin assegna il super-admin', function (): void {
    expect(Role::mayAssignSuperAdmin(roleAssignableActor('super-admin')))->toBeTrue();
});

test('per chi non e super-admin la query esclude il ruolo super-admin, con la colonna qualificata', function (): void {
    /** @var MockInterface&Builder<Role> $query */
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('qualifyColumn')->with('name')->andReturn('roles.name');
    $query->shouldReceive('where')->once()->with('roles.name', '!=', 'super-admin')->andReturnSelf();

    expect(Role::restrictAssignableBy($query, roleAssignableActor('user::admin')))->toBe($query);
});

test('anche senza operatore autenticato la query esclude il super-admin', function (): void {
    /** @var MockInterface&Builder<Role> $query */
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('qualifyColumn')->with('name')->andReturn('roles.name');
    $query->shouldReceive('where')->once()->with('roles.name', '!=', 'super-admin')->andReturnSelf();

    expect(Role::restrictAssignableBy($query, null))->toBe($query);
});

test('per un super-admin la query resta intatta', function (): void {
    /** @var MockInterface&Builder<Role> $query */
    $query = Mockery::mock(Builder::class);
    $query->shouldNotReceive('where');

    expect(Role::restrictAssignableBy($query, roleAssignableActor('super-admin')))->toBe($query);
});
