<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Socialite\Utils;

use Laravel\Socialite\Contracts\User as SocialiteUser;
use Modules\User\Actions\Socialite\Utils\UserNameFieldsResolver;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserNameFieldsResolverTest extends TestCase
{
    #[Test]
    public function itResolvesFirstAndLastNameFromFullName(): void
    {
        $ssoUser = $this->createMockSocialiteUser('John Doe', 'john@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        $this->assertEquals('Doe', $resolver->lastName);
    }

    #[Test]
    public function itResolvesNameFromSingleWord(): void
    {
        $ssoUser = $this->createMockSocialiteUser('John', 'john@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        // Single word name results in firstName = lastName = 'John'
        $this->assertEquals('John', $resolver->lastName);
    }

    #[Test]
    public function itFallsBackToEmailWhenNameIsEmpty(): void
    {
        $ssoUser = $this->createMockSocialiteUser(null, 'john.doe@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        $this->assertEquals('Doe', $resolver->lastName);
    }

    #[Test]
    public function itHandlesEmptyNameAndEmail(): void
    {
        $ssoUser = $this->createMockSocialiteUser(null, null);
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('', $resolver->firstName);
        $this->assertEquals('', $resolver->lastName);
    }

    #[Test]
    public function itHandlesEmptyStringName(): void
    {
        $ssoUser = $this->createMockSocialiteUser('', '');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('', $resolver->firstName);
        $this->assertEquals('', $resolver->lastName);
    }

    #[Test]
    public function itResolvesThreeWordNames(): void
    {
        $ssoUser = $this->createMockSocialiteUser('John Michael Doe', 'john@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        $this->assertEquals('Michael Doe', $resolver->lastName);
    }

    private function createMockSocialiteUser(?string $name, ?string $email): SocialiteUser
    {
        $mock = $this->createMock(SocialiteUser::class);
        $mock->method('getName')->willReturn($name);
        $mock->method('getEmail')->willReturn($email);

        return $mock;
    }
}
