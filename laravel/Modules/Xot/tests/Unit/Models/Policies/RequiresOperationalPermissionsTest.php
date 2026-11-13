<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\Concerns\RequiresOperationalPermissions;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-user-db');

final class OperationalPermissionsPolicyModel extends Model {}

final class OperationalPermissionsPolicyProbe extends XotBasePolicy
{
    use RequiresOperationalPermissions;
}

test('il ruolo del pannello non bypassa le policy che richiedono permessi operativi', function (): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnFalse();
    $user->shouldReceive('hasRole')
        ->with('xot::admin')
        ->andReturnTrue();

    Gate::policy(OperationalPermissionsPolicyModel::class, OperationalPermissionsPolicyProbe::class);

    expect(Gate::forUser($user)->allows('deleteAny', new OperationalPermissionsPolicyModel))
        ->toBeFalse();
});

test('il super-admin bypassa anche le policy con permessi operativi', function (): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnTrue();

    Gate::policy(OperationalPermissionsPolicyModel::class, OperationalPermissionsPolicyProbe::class);

    expect(Gate::forUser($user)->allows('deleteAny', new OperationalPermissionsPolicyModel))
        ->toBeTrue();
});
