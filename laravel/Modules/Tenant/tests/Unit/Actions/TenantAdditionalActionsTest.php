<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions;

use Modules\Tenant\Actions\Models\ResolveTenantModelInstanceAction;
use Modules\Tenant\Actions\Modules\GetTenantModulesAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

describe('Tenant Additional Actions Coverage', function (): void {
    test('GetTenantModulesAction is accessible', function (): void {
        expect(app(GetTenantModulesAction::class))->toBeInstanceOf(GetTenantModulesAction::class);
    });

    test('TranslateTenantKeyAction is accessible', function (): void {
        expect(app(TranslateTenantKeyAction::class))->toBeInstanceOf(TranslateTenantKeyAction::class);
    });

    test('ResolveTenantModelInstanceAction is accessible', function (): void {
        expect(app(ResolveTenantModelInstanceAction::class))->toBeInstanceOf(ResolveTenantModelInstanceAction::class);
    });

    test('GetTenantModulesAction has execute method', function (): void {
        expect(method_exists(app(GetTenantModulesAction::class), 'execute'))->toBeTrue();
    });

    test('TranslateTenantKeyAction has execute method', function (): void {
        expect(method_exists(app(TranslateTenantKeyAction::class), 'execute'))->toBeTrue();
    });

    test('ResolveTenantModelInstanceAction has execute method', function (): void {
        expect(method_exists(app(ResolveTenantModelInstanceAction::class), 'execute'))->toBeTrue();
    });
});
