<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\User;

use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('User Misc Actions Coverage', function (): void {
    test('GetCurrentDeviceAction is accessible', function (): void {
        expect(app(GetCurrentDeviceAction::class))->toBeInstanceOf(GetCurrentDeviceAction::class);
    });

    test('LogRegistrationAction is accessible', function (): void {
        expect(app(LogRegistrationAction::class))->toBeInstanceOf(LogRegistrationAction::class);
    });

    test('SendOtpByUserAction is accessible', function (): void {
        expect(app(SendOtpByUserAction::class))->toBeInstanceOf(SendOtpByUserAction::class);
    });

    test('GetCurrentDeviceAction has execute method', function (): void {
        $action = app(GetCurrentDeviceAction::class);
        expect(method_exists($action, 'execute'))->toBeTrue();
    });

    test('LogRegistrationAction has execute method', function (): void {
        $action = app(LogRegistrationAction::class);
        expect(method_exists($action, 'execute'))->toBeTrue();
    });

    test('SendOtpByUserAction has execute method', function (): void {
        $action = app(SendOtpByUserAction::class);
        expect(method_exists($action, 'execute'))->toBeTrue();
    });
});
