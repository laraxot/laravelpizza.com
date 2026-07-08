<?php

declare(strict_types=1);

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\User\Enums\UserType;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('user type enum has correct cases', function (): void {
    Assert::assertCount(5, UserType::cases());
    Assert::assertSame('master_admin', UserType::MasterAdmin->value);
    Assert::assertSame('backoffice_user', UserType::BoUser->value);
    Assert::assertSame('customer_user', UserType::CustomerUser->value);
    Assert::assertSame('system', UserType::System->value);
    Assert::assertSame('technician', UserType::Technician->value);
});

test('user type enum implements required interfaces', function (): void {
    $reflection = new ReflectionClass(UserType::class);

    Assert::assertTrue($reflection->implementsInterface(HasColor::class));
    Assert::assertTrue($reflection->implementsInterface(HasIcon::class));
    Assert::assertTrue($reflection->implementsInterface(HasLabel::class));
});

test('user type enum getLabel method returns translation keys', function (): void {
    Assert::assertSame('user::user_type.values.master_admin.label', UserType::MasterAdmin->getLabel());
    Assert::assertSame('user::user_type.values.backoffice_user.label', UserType::BoUser->getLabel());
    Assert::assertSame('user::user_type.values.customer_user.label', UserType::CustomerUser->getLabel());
    Assert::assertSame('user::user_type.values.system.label', UserType::System->getLabel());
    Assert::assertSame('user::user_type.values.technician.label', UserType::Technician->getLabel());
});

test('user type enum getColor method returns translation keys', function (): void {
    Assert::assertSame('user::user_type.values.master_admin.color', UserType::MasterAdmin->getColor());
    Assert::assertSame('user::user_type.values.backoffice_user.color', UserType::BoUser->getColor());
    Assert::assertSame('user::user_type.values.customer_user.color', UserType::CustomerUser->getColor());
    Assert::assertSame('user::user_type.values.system.color', UserType::System->getColor());
    Assert::assertSame('user::user_type.values.technician.color', UserType::Technician->getColor());
});

test('user type enum getIcon method returns translation keys', function (): void {
    Assert::assertSame('user::user_type.values.master_admin.icon', UserType::MasterAdmin->getIcon());
    Assert::assertSame('user::user_type.values.backoffice_user.icon', UserType::BoUser->getIcon());
    Assert::assertSame('user::user_type.values.customer_user.icon', UserType::CustomerUser->getIcon());
    Assert::assertSame('user::user_type.values.system.icon', UserType::System->getIcon());
    Assert::assertSame('user::user_type.values.technician.icon', UserType::Technician->getIcon());
});

test('user type enum getDefaultGuard method returns correct guards', function (): void {
    Assert::assertSame('web', UserType::MasterAdmin->getDefaultGuard());
    Assert::assertSame('web', UserType::BoUser->getDefaultGuard());
    Assert::assertSame('web', UserType::CustomerUser->getDefaultGuard());
    Assert::assertSame('web', UserType::System->getDefaultGuard());
    Assert::assertSame('api', UserType::Technician->getDefaultGuard());
});

test('user type enum can be compared', function (): void {
    Assert::assertSame(UserType::MasterAdmin, UserType::MasterAdmin);
    Assert::assertNotSame(UserType::MasterAdmin, UserType::BoUser);
});

test('user type enum can be used in match statements', function (): void {
    $getMatchResult = static function (UserType $type): string {
        return match ($type) {
            UserType::MasterAdmin => 'admin',
            UserType::BoUser => 'backoffice',
            UserType::CustomerUser => 'customer',
            UserType::System => 'system',
            UserType::Technician => 'technician',
        };
    };

    Assert::assertSame('admin', $getMatchResult(UserType::MasterAdmin));
    Assert::assertSame('backoffice', $getMatchResult(UserType::BoUser));
    Assert::assertSame('customer', $getMatchResult(UserType::CustomerUser));
    Assert::assertSame('system', $getMatchResult(UserType::System));
    Assert::assertSame('technician', $getMatchResult(UserType::Technician));
});

test('user type enum can be serialized', function (): void {
    $serialized = serialize(UserType::MasterAdmin);

    Assert::assertMatchesRegularExpression('/^E:\d+:"Modules\\\User\\\Enums\\\UserType:MasterAdmin";$/', $serialized);
});

test('user type enum can be unserialized', function (): void {
    $serialized = serialize(UserType::MasterAdmin);
    $unserialized = \Safe\unserialize($serialized);

    Assert::assertInstanceOf(UserType::class, $unserialized);
    Assert::assertSame(UserType::MasterAdmin, $unserialized);
});
