<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions;

use Modules\Tenant\Actions\Models\ResolveTenantModelInstanceAction;
use Modules\Tenant\Actions\Modules\GetTenantModulesAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Tenant Additional Actions Coverage', function (): void {
    test('GetTenantModulesAction is accessible', function (): void {
        Assert::assertInstanceOf(GetTenantModulesAction::class, app(GetTenantModulesAction::class));
    });

    test('TranslateTenantKeyAction is accessible', function (): void {
        Assert::assertInstanceOf(TranslateTenantKeyAction::class, app(TranslateTenantKeyAction::class));
    });

    test('ResolveTenantModelInstanceAction is accessible', function (): void {
        Assert::assertInstanceOf(ResolveTenantModelInstanceAction::class, app(ResolveTenantModelInstanceAction::class));
    });

    test('GetTenantModulesAction has execute method', function (): void {
        Assert::assertTrue(method_exists(app(GetTenantModulesAction::class), 'execute'));
    });

    test('TranslateTenantKeyAction has execute method', function (): void {
        Assert::assertTrue(method_exists(app(TranslateTenantKeyAction::class), 'execute'));
    });

    test('ResolveTenantModelInstanceAction has execute method', function (): void {
        Assert::assertTrue(method_exists(app(ResolveTenantModelInstanceAction::class), 'execute'));
    });
});
