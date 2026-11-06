<?php

declare(strict_types=1);
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Misc Actions Coverage', function (): void {
    test('GetCurrentDeviceAction is accessible', function (): void {
        Assert::assertInstanceOf(GetCurrentDeviceAction::class, app(GetCurrentDeviceAction::class));
    });

    test('LogRegistrationAction is accessible', function (): void {
        Assert::assertInstanceOf(LogRegistrationAction::class, app(LogRegistrationAction::class));
    });

    test('SendOtpByUserAction is accessible', function (): void {
        Assert::assertInstanceOf(SendOtpByUserAction::class, app(SendOtpByUserAction::class));
    });

    test('GetCurrentDeviceAction has execute method', function (): void {
        $action = app(GetCurrentDeviceAction::class);

        Assert::assertTrue(method_exists($action, 'execute'));
    });

    test('LogRegistrationAction has execute method', function (): void {
        $action = app(LogRegistrationAction::class);

        Assert::assertTrue(method_exists($action, 'execute'));
    });

    test('SendOtpByUserAction has execute method', function (): void {
        $action = app(SendOtpByUserAction::class);

        Assert::assertTrue(method_exists($action, 'execute'));
    });
});
