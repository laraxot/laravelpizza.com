<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\User\Actions\User\GetNewPasswordAction;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('GetNewPasswordAction', function (): void {
    it('generates and stores a new hashed password for the user', function (): void {
        $user = UserFactory::new()->createOne([
            'password' => Hash::make('old-password'),
        ]);

        $oldHash = (string) $user->password;

        $plainPassword = app(GetNewPasswordAction::class)->execute($user);

        $user->refresh();

        Assert::assertIsString($plainPassword);
        Assert::assertNotSame('', $plainPassword);
        Assert::assertNotSame($oldHash, (string) $user->password);
        Assert::assertTrue(Hash::check($plainPassword, (string) $user->password));
    });

    it('can regenerate password multiple times', function (): void {
        $user = UserFactory::new()->createOne();

        $firstPlain = app(GetNewPasswordAction::class)->execute($user);
        $freshModel0 = $user->fresh();
        Assert::assertNotNull($freshModel0);
        $firstHash = (string) $freshModel0->password;

        $refreshedUser = $user->fresh();
        if (null === $refreshedUser) {
            Assert::fail('User refresh failed.');
        }
        $secondPlain = app(GetNewPasswordAction::class)->execute($refreshedUser);
        $freshModel1 = $user->fresh();
        Assert::assertNotNull($freshModel1);
        $secondHash = (string) $freshModel1->password;

        Assert::assertIsString($secondPlain);
        Assert::assertNotSame($firstPlain, $secondPlain);
        Assert::assertNotSame($firstHash, $secondHash);
        Assert::assertTrue(Hash::check($firstPlain, $firstHash));
        Assert::assertTrue(Hash::check($secondPlain, $secondHash));
    });
});
