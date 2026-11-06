<?php

declare(strict_types=1);
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Modules\User\Actions\Socialite\ResolveUserNameFieldsFromSocialiteAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function createMockSocialiteUser(?string $name, ?string $email): SocialiteUser
{
    $mock = typedMock(SocialiteUser::class);
    $mock->allows([
        'getName' => $name,
        'getEmail' => $email,
    ]);

    return $mock;
}

it('resolves first and last name from full name', function (): void {
    $ssoUser = createMockSocialiteUser('John Doe', 'john@example.com');
    $fields = app(ResolveUserNameFieldsFromSocialiteAction::class)->execute($ssoUser);

    Assert::assertSame('John', $fields->firstName);
    Assert::assertSame('Doe', $fields->lastName);
});

it('resolves name from single word', function (): void {
    $ssoUser = createMockSocialiteUser('John', 'john@example.com');
    $fields = app(ResolveUserNameFieldsFromSocialiteAction::class)->execute($ssoUser);

    Assert::assertSame('John', $fields->firstName);
    Assert::assertSame('John', $fields->lastName);
});

it('falls back to email when name is empty', function (): void {
    $ssoUser = createMockSocialiteUser(null, 'john.doe@example.com');
    $fields = app(ResolveUserNameFieldsFromSocialiteAction::class)->execute($ssoUser);

    Assert::assertSame('John', $fields->firstName);
    Assert::assertSame('Doe', $fields->lastName);
});

it('handles empty name and email', function (): void {
    $ssoUser = createMockSocialiteUser(null, null);
    $fields = app(ResolveUserNameFieldsFromSocialiteAction::class)->execute($ssoUser);

    Assert::assertSame('', $fields->firstName);
    Assert::assertSame('', $fields->lastName);
});

it('handles empty string name', function (): void {
    $ssoUser = createMockSocialiteUser('', '');
    $fields = app(ResolveUserNameFieldsFromSocialiteAction::class)->execute($ssoUser);

    Assert::assertSame('', $fields->firstName);
    Assert::assertSame('', $fields->lastName);
});

it('resolves three word names', function (): void {
    $ssoUser = createMockSocialiteUser('John Michael Doe', 'john@example.com');
    $fields = app(ResolveUserNameFieldsFromSocialiteAction::class)->execute($ssoUser);

    Assert::assertSame('John', $fields->firstName);
    Assert::assertSame('Michael Doe', $fields->lastName);
});
