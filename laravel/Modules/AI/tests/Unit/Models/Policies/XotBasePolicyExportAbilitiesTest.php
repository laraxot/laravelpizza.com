<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Tests\TestCase;

use function Safe\preg_match_all;

uses(TestCase::class)->group('no-user-db');

final class ExportAbilityPolicyModel extends Model {}

final class ExportAbilityPolicyProbe extends XotBasePolicy {}

/**
 * Laravel chiama `before()` solo se la policy ha il metodo dell'abilita'
 * (`Gate::resolvePolicyCallback`): un'abilita' usata in `->authorize('x')` e non
 * dichiarata in XotBasePolicy nega anche super-admin e nasconde il bottone
 * (regressione export PDF/XLS sparite dalle liste IndennitaResponsabilita).
 */
test('every ability authorized by Xot Filament actions is declared on XotBasePolicy', function (): void {
    $abilities = [];
    foreach (File::allFiles(module_path('Xot', 'app/Filament')) as $file) {
        preg_match_all("/->authorize\\('([A-Za-z]+)'\\)/", $file->getContents(), $matches);
        $abilities = [...$abilities, ...$matches[1]];
    }

    expect($abilities)->not->toBeEmpty();

    foreach (array_unique($abilities) as $ability) {
        expect(method_exists(XotBasePolicy::class, $ability))
            ->toBeTrue("XotBasePolicy::{$ability}() mancante: before() verrebbe saltato");
    }
});

test('super-admin passes export abilities on a policy that does not override them', function (string $ability): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturnTrue();

    Gate::policy(ExportAbilityPolicyModel::class, ExportAbilityPolicyProbe::class);

    expect(Gate::forUser($user)->allows($ability, new ExportAbilityPolicyModel))
        ->toBeTrue();
})->with([
    'xlsExport',
    'graduatoriaPdf',
]);

test('ordinary users are denied export abilities by default', function (string $ability): void {
    /** @var UserContract&Authorizable&MockInterface $user */
    $user = Mockery::mock(UserContract::class, Authorizable::class);
    $user->shouldReceive('hasRole')
        ->andReturnFalse();

    Gate::policy(ExportAbilityPolicyModel::class, ExportAbilityPolicyProbe::class);

    expect(Gate::forUser($user)->allows($ability, new ExportAbilityPolicyModel))
        ->toBeFalse();
})->with([
    'xlsExport',
    'graduatoriaPdf',
]);
