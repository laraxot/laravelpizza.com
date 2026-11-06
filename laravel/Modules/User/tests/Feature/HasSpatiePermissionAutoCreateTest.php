<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Permission;
use Modules\User\Models\Policies\OauthAccessTokenPolicy;
use Modules\User\Models\Traits\HasSpatiePermission;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

uses(TestCase::class);

/**
 * Copre il fix per l'errore reale in produzione:
 * `PermissionDoesNotExist` ("no permission named oauth-access-token.view.any
 * for guard web") su `OauthAccessTokenPolicy::viewAny()`.
 *
 * @see HasSpatiePermission::hasPermissionToOrCreate()
 * @see OauthAccessTokenPolicy::viewAny()
 */
describe('HasSpatiePermission::hasPermissionToOrCreate', function (): void {
    test('permesso esistente si comporta come hasPermissionTo standard', function (): void {
        $user = UserFactory::new()->createOne();
        $permission = PermissionFactory::new()->createOne(['name' => 'existing.permission']);
        $user->givePermissionTo($permission);

        Assert::assertTrue($user->hasPermissionToOrCreate('existing.permission'));

        $other = UserFactory::new()->createOne();
        Assert::assertFalse($other->hasPermissionToOrCreate('existing.permission'));
    });

    test('permesso mancante non esplode più, viene creato e nega accesso', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertNull(
            Permission::query()->where('name', 'oauth-access-token.view.any')->first(),
        );

        $result = $user->hasPermissionToOrCreate('oauth-access-token.view.any');

        Assert::assertFalse($result);
        Assert::assertNotNull(
            Permission::query()->where('name', 'oauth-access-token.view.any')->first(),
            'il permesso deve esistere in DB dopo la prima chiamata',
        );
    });

    test('hasPermissionTo standard continua a esplodere se il permesso manca', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertNull(
            Permission::query()->where('name', 'still.missing.permission')->first(),
        );

        $threw = false;

        try {
            $user->hasPermissionTo('still.missing.permission');
        } catch (PermissionDoesNotExist) {
            $threw = true;
        }

        Assert::assertTrue($threw, 'hasPermissionTo() normale non deve auto-creare, solo hasPermissionToOrCreate()');
    });

    test('permesso auto-creato è poi assegnabile e funziona normalmente', function (): void {
        $user = UserFactory::new()->createOne();

        $user->hasPermissionToOrCreate('newly.created.permission');

        $permission = Permission::query()->where('name', 'newly.created.permission')->firstOrFail();
        $user->givePermissionTo($permission);

        Assert::assertTrue($user->hasPermissionTo('newly.created.permission'));
    });

    test('OauthAccessTokenPolicy::viewAny non esplode più su permesso mancante', function (): void {
        $user = UserFactory::new()->createOne();

        $policy = new OauthAccessTokenPolicy;

        Assert::assertFalse($policy->viewAny($user));
    });
});
