<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-user-db');

final class UndeclaredAbilityPolicyModel extends Model {}

final class UndeclaredAbilityPolicyProbe extends XotBasePolicy {}

test('undeclared Filament bulk abilities are denied to ordinary users', function (): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnFalse();

    Gate::policy(UndeclaredAbilityPolicyModel::class, UndeclaredAbilityPolicyProbe::class);

    expect(Gate::forUser($user)->allows('deleteAny', new UndeclaredAbilityPolicyModel))
        ->toBeFalse();
});

test('super-admin bypass remains available for undeclared Filament abilities', function (): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnTrue();

    Gate::policy(UndeclaredAbilityPolicyModel::class, UndeclaredAbilityPolicyProbe::class);

    expect(Gate::forUser($user)->allows('deleteAny', new UndeclaredAbilityPolicyModel))
        ->toBeTrue();
});
