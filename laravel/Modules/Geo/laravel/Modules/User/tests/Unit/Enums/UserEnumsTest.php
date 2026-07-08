<?php

declare(strict_types=1);

use Modules\User\Enums\LanguageEnum;
use Modules\User\Enums\SocialProviderEnum;
use Modules\User\Enums\SystemRole;
use Modules\User\Enums\UserType;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('UserType enum has expected cases', function (): void {
    $values = array_map(static fn ($case) => $case->value, UserType::cases());

    Assert::assertContains('master_admin', $values);
    Assert::assertContains('customer_user', $values);
});

test('SystemRole enum has expected cases', function (): void {
    $values = array_map(static fn ($case) => $case->value, SystemRole::cases());

    Assert::assertContains('%', $values);
});

test('SocialProviderEnum enum has expected cases', function (): void {
    $values = array_map(static fn ($case) => $case->value, SocialProviderEnum::cases());

    Assert::assertContains('google', $values);
    Assert::assertContains('auth0', $values);
});

test('LanguageEnum enum has expected cases', function (): void {
    $values = array_map(static fn ($case) => $case->value, LanguageEnum::cases());

    Assert::assertContains('it', $values);
    Assert::assertContains('en', $values);
});

test('UserType has getLabel method', function (): void {
});
