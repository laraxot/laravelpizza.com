<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Modules\Tenant\Models\TenantSetting;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Multi-tenant scope', function (): void {
    beforeEach(function (): void {
        if (TestCase::tenantDbUnavailable()) {
            TestCase::skipCurrentTest('Tenant DB write blocked on shared sqlite');
        }
    });

    it('scopes queries to tenant id', function (): void {
        $tenant1 = TestCase::createTenant(['name' => 'scope-tenant-1']);
        $tenant2 = TestCase::createTenant(['name' => 'scope-tenant-2']);

        TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'setting', 'value' => 'value-1']);
        TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'setting', 'value' => 'value-2']);

        $settings1 = TenantSetting::query()->where('tenant_id', $tenant1->id)->get();
        $settings2 = TenantSetting::query()->where('tenant_id', $tenant2->id)->get();

        Assert::assertCount(1, $settings1);
        $first1 = $settings1->first();
        Assert::assertInstanceOf(TenantSetting::class, $first1);
        Assert::assertSame('value-1', $first1->value);

        Assert::assertCount(1, $settings2);
        $first2 = $settings2->first();
        Assert::assertInstanceOf(TenantSetting::class, $first2);
        Assert::assertSame('value-2', $first2->value);
    });

    it('keeps rows separable without global scope', function (): void {
        $tenant1 = TestCase::createTenant(['name' => 'global-1']);
        $tenant2 = TestCase::createTenant(['name' => 'global-2']);

        TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'private', 'value' => 'secret-1']);
        TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'private', 'value' => 'secret-2']);

        Assert::assertCount(2, TenantSetting::query()->get());
    });

    it('enforces isolation when filtering by tenant_id', function (): void {
        $tenant1 = TestCase::createTenant(['name' => 'aware-1']);
        $tenant2 = TestCase::createTenant(['name' => 'aware-2']);

        TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'test', 'value' => 'v1']);
        TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'test', 'value' => 'v2']);

        $scoped1 = TenantSetting::query()->where('tenant_id', $tenant1->id)->first();
        $scoped2 = TenantSetting::query()->where('tenant_id', $tenant2->id)->first();

        Assert::assertInstanceOf(TenantSetting::class, $scoped1);
        Assert::assertInstanceOf(TenantSetting::class, $scoped2);
        Assert::assertSame('v1', $scoped1->value);
        Assert::assertSame('v2', $scoped2->value);
    });
});
