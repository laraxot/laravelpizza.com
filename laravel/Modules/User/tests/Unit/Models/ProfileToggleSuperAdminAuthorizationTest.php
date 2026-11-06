<?php

declare(strict_types=1);

use Illuminate\Auth\Access\AuthorizationException;
use Mockery\MockInterface;
use Modules\User\Models\Profile;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

/*
 * DCP-181 (audit Filament, A-3): `SuperAdminWidget` e' reso nel menu utente di OGNI pannello e `toggleSuperAdmin()` e' un'azione Livewire pubblica.
 * Il metodo del profilo assegnava `super-admin` a chiunque lo chiamasse. Si puo' invertire solo un ruolo che si ha gia' (`super-admin` o
 * `negate-super-admin`): e' lo stesso criterio con cui la vista decide se mostrare il pulsante.
 */
/**
 * @return array{0: Profile, 1: MockInterface}
 */
function profileWithRoles(bool $isSuperAdmin, bool $isNegateSuperAdmin): array
{
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);
    $user->shouldReceive('hasRole')->with('negate-super-admin')->andReturn($isNegateSuperAdmin);

    $profile = new Profile;
    $profile->setRelation('user', $user);

    return [$profile, $user];
}

describe('Profile::toggleSuperAdmin authorization', function (): void {
    test('refuses a user who has neither role and assigns nothing', function (): void {
        [$profile, $user] = profileWithRoles(false, false);
        $user->shouldNotReceive('assignRole');
        $user->shouldNotReceive('removeRole');

        expect(fn () => $profile->toggleSuperAdmin())->toThrow(AuthorizationException::class);
    });

    test('lets a super-admin step down to negate-super-admin', function (): void {
        [$profile, $user] = profileWithRoles(true, false);
        $user->shouldReceive('assignRole')->once()->with('negate-super-admin');
        $user->shouldReceive('removeRole')->once()->with('super-admin');

        $profile->toggleSuperAdmin();
    });

    test('lets a negate-super-admin go back to super-admin', function (): void {
        [$profile, $user] = profileWithRoles(false, true);
        $user->shouldReceive('assignRole')->once()->with('super-admin');
        $user->shouldReceive('removeRole')->once()->with('negate-super-admin');

        $profile->toggleSuperAdmin();
    });
});
