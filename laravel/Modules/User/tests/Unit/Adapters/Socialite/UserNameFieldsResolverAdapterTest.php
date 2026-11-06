<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Adapters\Socialite;

use Laravel\Socialite\Contracts\User as SocialiteUser;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\User\Adapters\Socialite\UserNameFieldsResolver;
use Modules\User\Tests\TestCase;
use Modules\User\Tests\Unit\Adapters\Socialite\Fixtures\SocialiteUserWithRawFixture;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-user-db');

/**
 * @param  array<string, mixed>  $raw
 */
function adapterSocialiteUserMock(?string $name, ?string $email, array $raw = []): SocialiteUser
{
    return \configureMock(SocialiteUser::class, static function (MockInterface $mock) use ($name, $email, $raw): void {
        $mock->allows([
            'getName' => $name,
            'getEmail' => $email,
        ]);
        if ($raw !== []) {
            $expectation = $mock->allows('getRaw');
            \assert($expectation instanceof Expectation);
            $expectation->andReturn($raw);
        }
    });
}

describe('Adapter UserNameFieldsResolver', function (): void {
    test('resolve first and last name from full name attribute', function (): void {
        $resolver = UserNameFieldsResolver::make(adapterSocialiteUserMock('Mario Rossi', 'mario@example.com'));

        Assert::assertSame('Mario', $resolver->firstName);
        Assert::assertSame('Rossi', $resolver->lastName);
        Assert::assertSame('Mario', $resolver->name);
    });

    test('falls back to email local part when name is empty', function (): void {
        $resolver = UserNameFieldsResolver::make(adapterSocialiteUserMock(null, 'luigi.verdi@example.com'));

        Assert::assertSame('Luigi', $resolver->firstName);
        Assert::assertSame('Verdi', $resolver->lastName);
    });

    test('uses raw name when getName is empty but raw contains name', function (): void {
        $resolver = UserNameFieldsResolver::make(
            new SocialiteUserWithRawFixture('', 'a@b.com', ['name' => 'Anna Bianchi'])
        );

        Assert::assertSame('Anna', $resolver->firstName);
        Assert::assertSame('Bianchi', $resolver->lastName);
    });

    test('ignores raw name that looks like email and uses email fallback', function (): void {
        $resolver = UserNameFieldsResolver::make(
            new SocialiteUserWithRawFixture('', 'paolo.neri@test.it', ['name' => 'paolo.neri@test.it'])
        );

        Assert::assertSame('Paolo', $resolver->firstName);
        Assert::assertSame('Neri', $resolver->lastName);
    });

    test('handles empty name and email gracefully', function (): void {
        $resolver = UserNameFieldsResolver::make(adapterSocialiteUserMock(null, null));

        Assert::assertSame('', $resolver->firstName);
        Assert::assertSame('', $resolver->lastName);
    });
});
