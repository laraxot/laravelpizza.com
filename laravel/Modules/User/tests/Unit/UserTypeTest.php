<?php

declare(strict_types=1);

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\User\Enums\UserType;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('user type enum has correct cases', function (): void {
    expect(UserType::cases())->toHaveCount(5);

    expect(UserType::MasterAdmin->value)->toBe('master_admin');
    expect(UserType::BoUser->value)->toBe('backoffice_user');
    expect(UserType::CustomerUser->value)->toBe('customer_user');
    expect(UserType::System->value)->toBe('system');
    expect(UserType::Technician->value)->toBe('technician');
});

test('user type enum implements required interfaces', function (): void {
    $reflection = new ReflectionClass(UserType::class);

    expect($reflection->implementsInterface(HasColor::class))->toBeTrue();
    expect($reflection->implementsInterface(HasIcon::class))->toBeTrue();
    expect($reflection->implementsInterface(HasLabel::class))->toBeTrue();
});

test('user type enum getLabel method returns correct labels', function (): void {
    expect(UserType::MasterAdmin->getLabel())->toBe('master_admin');
    expect(UserType::BoUser->getLabel())->toBe('backoffice_user');
    expect(UserType::CustomerUser->getLabel())->toBe('customer_user');
    expect(UserType::System->getLabel())->toBe('system');
    expect(UserType::Technician->getLabel())->toBe('technician');
});

test('user type enum getColor method returns correct colors', function (): void {
    expect(UserType::MasterAdmin->getColor())->toBe('success');
    expect(UserType::BoUser->getColor())->toBe('warning');
    expect(UserType::CustomerUser->getColor())->toBe('gray');
    expect(UserType::System->getColor())->toBe('blue');
    expect(UserType::Technician->getColor())->toBe('green');
});

test('user type enum getIcon method returns correct icons', function (): void {
    expect(UserType::MasterAdmin->getIcon())->toBe('heroicon-m-pencil');
    expect(UserType::BoUser->getIcon())->toBe('heroicon-m-pencil');
    expect(UserType::CustomerUser->getIcon())->toBe('heroicon-m-pencil');
    expect(UserType::System->getIcon())->toBe('heroicon-m-pencil');
    expect(UserType::Technician->getIcon())->toBe('heroicon-m-pencil');
});

test('user type enum getDefaultGuard method returns correct guards', function (): void {
    expect(UserType::MasterAdmin->getDefaultGuard())->toBe('web');
    expect(UserType::BoUser->getDefaultGuard())->toBe('web');
    expect(UserType::CustomerUser->getDefaultGuard())->toBe('web');
    expect(UserType::System->getDefaultGuard())->toBe('web');
    expect(UserType::Technician->getDefaultGuard())->toBe('api');
});

test('user type enum can be used in database queries', function (): void {
    $masterAdmin = UserType::MasterAdmin;
    $boUser = UserType::BoUser;

    expect($masterAdmin->value)->toBe('master_admin');
    expect($boUser->value)->toBe('backoffice_user');
});

test('user type enum can be compared', function (): void {
    $type1 = UserType::MasterAdmin;
    $type2 = UserType::MasterAdmin;
    $type3 = UserType::BoUser;

    expect($type1)->toBe($type2);
    expect($type1)->not->toBe($type3);
});

test('user type enum can be used in match statements', function (): void {
    $getMatchResult = function (UserType $type): string {
        return match ($type) {
            UserType::MasterAdmin => 'admin',
            UserType::BoUser => 'backoffice',
            UserType::CustomerUser => 'customer',
            UserType::System => 'system',
            UserType::Technician => 'technician',
        };
    };

    expect($getMatchResult(UserType::MasterAdmin))->toBe('admin');
    expect($getMatchResult(UserType::BoUser))->toBe('backoffice');
    expect($getMatchResult(UserType::CustomerUser))->toBe('customer');
    expect($getMatchResult(UserType::System))->toBe('system');
    expect($getMatchResult(UserType::Technician))->toBe('technician');
});

test('user type enum can be serialized', function (): void {
    $type = UserType::MasterAdmin;
    $serialized = serialize($type);

    // PHP 8.1+ enum serialization format: E:length:"Namespace\Enum:CaseName";
    expect($serialized)->toMatch('/^E:\d+:"Modules\\\User\\\Enums\\\UserType:MasterAdmin";$/');
});

test('user type enum can be unserialized', function (): void {
    $type = UserType::MasterAdmin;
    $serialized = serialize($type);
    $unserialized = unserialize($serialized);

    expect($unserialized)->toBe(UserType::MasterAdmin);
});

test('user type enum has correct string representation', function (): void {
    expect(UserType::MasterAdmin->value)->toBe('master_admin');
    expect(UserType::BoUser->value)->toBe('backoffice_user');
    expect(UserType::CustomerUser->value)->toBe('customer_user');
    expect(UserType::System->value)->toBe('system');
    expect(UserType::Technician->value)->toBe('technician');
});
