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
    public function it_resolves_first_and_last_name_from_full_name(): void
    {
        $ssoUser = $this->createMockSocialiteUser('John Doe', 'john@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        $this->assertEquals('Doe', $resolver->lastName);
    }

    #[Test]
    public function it_resolves_name_from_single_word(): void
    {
        $ssoUser = $this->createMockSocialiteUser('John', 'john@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        // Single word name results in firstName = lastName = 'John'
        $this->assertEquals('John', $resolver->lastName);
    }

    #[Test]
    public function it_falls_back_to_email_when_name_is_empty(): void
    {
        $ssoUser = $this->createMockSocialiteUser(null, 'john.doe@example.com');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('John', $resolver->firstName);
        $this->assertEquals('Doe', $resolver->lastName);
    }

    #[Test]
    public function it_handles_empty_name_and_email(): void
    {
        $ssoUser = $this->createMockSocialiteUser(null, null);
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('', $resolver->firstName);
        $this->assertEquals('', $resolver->lastName);
    }

    #[Test]
    public function it_handles_empty_string_name(): void
    {
        $ssoUser = $this->createMockSocialiteUser('', '');
        $resolver = UserNameFieldsResolver::make($ssoUser);

        $this->assertEquals('', $resolver->firstName);
        $this->assertEquals('', $resolver->lastName);
    }

    #[Test]
    public function it_resolves_three_word_names(): void
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
