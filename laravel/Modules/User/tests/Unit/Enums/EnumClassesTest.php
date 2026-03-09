<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Enums\SocialProviderEnum;
use Modules\User\Enums\SystemRole;
use Modules\User\Enums\UserType;

test('UserType enum has all cases', function () {
    $cases = UserType::cases();

    expect($cases)->toHaveCount(5)
        ->and($cases)->each->toBeInstanceOf(UserType::class);
});

test('UserType enum cases have correct values', function () {
    expect(UserType::MasterAdmin->value)->toBe('master_admin')
        ->and(UserType::BoUser->value)->toBe('backoffice_user')
        ->and(UserType::CustomerUser->value)->toBe('customer_user')
        ->and(UserType::System->value)->toBe('system')
        ->and(UserType::Technician->value)->toBe('technician');
});

test('UserType getDefaultGuard method works', function () {
    expect(UserType::MasterAdmin->getDefaultGuard())->toBe('web')
        ->and(UserType::BoUser->getDefaultGuard())->toBe('web')
        ->and(UserType::CustomerUser->getDefaultGuard())->toBe('web')
        ->and(UserType::System->getDefaultGuard())->toBe('web')
        ->and(UserType::Technician->getDefaultGuard())->toBe('api');
});

test('UserType getLabel method works', function () {
    expect(UserType::MasterAdmin->getLabel())->toBe('master_admin')
        ->and(UserType::BoUser->getLabel())->toBe('backoffice_user')
        ->and(UserType::CustomerUser->getLabel())->toBe('customer_user')
        ->and(UserType::System->getLabel())->toBe('system')
        ->and(UserType::Technician->getLabel())->toBe('technician');
});

test('UserType getColor method works', function () {
    expect(UserType::MasterAdmin->getColor())->toBe('success')
        ->and(UserType::BoUser->getColor())->toBe('warning')
        ->and(UserType::CustomerUser->getColor())->toBe('gray')
        ->and(UserType::System->getColor())->toBe('blue')
        ->and(UserType::Technician->getColor())->toBe('green');
});

test('UserType getIcon method works', function () {
    expect(UserType::MasterAdmin->getIcon())->toBe('heroicon-m-pencil')
        ->and(UserType::BoUser->getIcon())->toBe('heroicon-m-pencil');
});

test('SystemRole enum can be instantiated', function () {
    $cases = SystemRole::cases();

    expect($cases)->each->toBeInstanceOf(SystemRole::class);
});

test('SocialProviderEnum can be instantiated', function () {
    $cases = SocialProviderEnum::cases();

    expect($cases)->each->toBeInstanceOf(SocialProviderEnum::class);
});
