<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Models;

use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Tenant model', function (): void {
    it('creates tenant with required fields', function (): void {
        if (TestCase::tenantDbUnavailable()) {
            TestCase::skipCurrentTest('Tenant DB write blocked on shared sqlite');
        }

        $tenant = Tenant::create([
            'name' => 'test-tenant',
            'domain' => 'test.example.com',
            'is_active' => true,
        ]);

        Assert::assertSame('test-tenant', $tenant->name);
        Assert::assertSame('test.example.com', $tenant->domain);
        Assert::assertTrue($tenant->is_active);
    });

    it('has fillable fields', function (): void {
        $fillable = (new Tenant)->getFillable();

        expect($fillable)->toContain('name');
        expect($fillable)->toContain('domain');
        expect($fillable)->toContain('is_active');
        expect($fillable)->toContain('settings');
    });

    it('casts settings to array when column exists', function (): void {
        if (TestCase::tenantDbUnavailable()) {
            TestCase::skipCurrentTest('Tenant DB write blocked on shared sqlite');
        }

        /** @var TenantFactory $factory */
        $factory = Tenant::factory();
        $tenant = $factory->withSettings(['theme' => 'dark', 'language' => 'en'])->create();
        Assert::assertInstanceOf(Tenant::class, $tenant);

        Assert::assertIsArray($tenant->settings);
        Assert::assertSame('dark', $tenant->settings['theme'] ?? null);
    });

    it('reports active state via isActive', function (): void {
        $tenant = new Tenant(['is_active' => true]);

        Assert::assertTrue($tenant->isActive());
    });

    it('builds url from domain attribute', function (): void {
        $tenant = new Tenant(['domain' => 'https://tenant.example.com']);

        Assert::assertSame('https://tenant.example.com', $tenant->url);
    });

    it('creates tenant via typed factory helper', function (): void {
        if (TestCase::tenantDbUnavailable()) {
            TestCase::skipCurrentTest('Tenant DB write blocked on shared sqlite');
        }

        $tenant = TestCase::createTenant(['name' => 'factory-tenant']);

        Assert::assertSame('factory-tenant', $tenant->name);
    });
});
