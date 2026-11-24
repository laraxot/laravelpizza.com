<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Tests\Fixtures\DemoModel;
use Modules\Xot\Tests\Fixtures\Policies\OperationalPermissionsPolicyProbe;
use Modules\Xot\Tests\TestCase;

/**
 * Guardia di sicurezza: il ruolo del pannello (`xot::admin`) serve solo a entrare, non a fare tutto,
 * quando la policy richiede permessi operativi. Non cancellare: e' l'unico test del trait nel progetto
 * (le policy che lo usano, Roosko, vivono in un altro progetto).
 *
 * @see Modules/Xot/docs/wiki/decisions/module-admin-role-policy-bypass.md regola protetta da questo test
 */
uses(TestCase::class)->group('no-user-db');

test('il ruolo del pannello non bypassa le policy che richiedono permessi operativi', function (): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnFalse();
    $user->shouldReceive('hasRole')
        ->with('xot::admin')
        ->andReturnTrue();

    Gate::policy(DemoModel::class, OperationalPermissionsPolicyProbe::class);

    expect(Gate::forUser($user)->allows('deleteAny', new DemoModel))
        ->toBeFalse();
});

test('il super-admin bypassa anche le policy con permessi operativi', function (): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnTrue();

    Gate::policy(DemoModel::class, OperationalPermissionsPolicyProbe::class);

    expect(Gate::forUser($user)->allows('deleteAny', new DemoModel))
        ->toBeTrue();
});
