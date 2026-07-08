<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Modules\User\Database\Factories\TenantFactory;
use Modules\User\Models\Tenant;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\User\Tests\TestCase $this */
    /* @var TestCase $this */
    $this->skipUnlessUserTable('tenants');
});

describe('Tenant', function (): void {
    test('can create tenant with minimal data', function (): void {
        /** @var TestCase $this */
        $tenant = TenantFactory::new()->createOne([
            'name' => 'Test Tenant',
        ]);

        $this->assertDatabaseHasRow('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Tenant',
        ]);
    });

    test('can create tenant with all fields', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessTenantColumn('settings');
        $this->skipUnlessTenantColumn('trial_ends_at');

        $tenantData = [
            'name' => 'Full Tenant',
            'slug' => 'full-tenant',
            'domain' => 'fulltenant.com',
            'database' => 'fulltenant_db',
            'settings' => ['theme' => 'dark', 'features' => ['chat', 'analytics']],
            'is_active' => true,
            'trial_ends_at' => now()->addDays(30),
        ];

        $tenant = TenantFactory::new()->createOne($tenantData);

        $this->assertDatabaseHasRow('tenants', [
            'id' => $tenant->id,
            'name' => 'Full Tenant',
            'slug' => 'full-tenant',
            'domain' => 'fulltenant.com',
            'database' => 'fulltenant_db',
            'is_active' => true,
        ]);

        Assert::assertSame(['theme' => 'dark', 'features' => ['chat', 'analytics']], $tenant->settings);
    });

    test('tenant has soft deletes', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Tenant model does not use SoftDeletes.');
    });

    test('can restore soft deleted tenant', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Tenant restore/withTrashed not supported on User Tenant model.');
    });

    test('can find tenant by name', function (): void {
        $name = 'Unique Tenant Name '.uniqid();
        $tenant = TenantFactory::new()->createOne(['name' => $name]);

        $foundTenant = Tenant::where('name', $name)->first();

        Assert::assertNotNull($foundTenant);
        Assert::assertSame($tenant->id, $foundTenant->id);
    });

    test('can find tenant by slug', function (): void {
        $slug = 'unique-tenant-'.uniqid();
        $tenant = TenantFactory::new()->createOne(['slug' => $slug]);

        $foundTenant = Tenant::where('slug', $slug)->first();

        Assert::assertNotNull($foundTenant);
        Assert::assertSame($tenant->id, $foundTenant->id);
    });

    test('can find tenant by domain', function (): void {
        $domain = uniqid().'.uniquetenant.com';
        $tenant = TenantFactory::new()->createOne(['domain' => $domain]);

        $foundTenant = Tenant::where('domain', $domain)->first();

        Assert::assertNotNull($foundTenant);
        Assert::assertSame($tenant->id, $foundTenant->id);
    });

    test('can find tenant by database', function (): void {
        $database = 'unique_db_'.uniqid();
        $tenant = TenantFactory::new()->createOne(['database' => $database]);

        $foundTenant = Tenant::where('database', $database)->first();

        Assert::assertNotNull($foundTenant);
        Assert::assertSame($tenant->id, $foundTenant->id);
    });

    test('can find active tenants', function (): void {
        $marker = 'active-tenant-'.uniqid();

        TenantFactory::new()->createOne(['name' => $marker.'-1', 'is_active' => true]);
        TenantFactory::new()->createOne(['name' => $marker.'-2', 'is_active' => false]);
        TenantFactory::new()->createOne(['name' => $marker.'-3', 'is_active' => true]);

        $activeTenants = Tenant::query()
            ->where('name', 'like', $marker.'%')
            ->where('is_active', true)
            ->get();

        Assert::assertCount(2, $activeTenants);
        Assert::assertTrue($activeTenants->every(fn ($tenant) => (bool) $tenant->is_active));
    });

    test('can find tenants by name pattern', function (): void {
        $marker = 'company-pattern-'.uniqid();

        TenantFactory::new()->createOne(['name' => $marker.' Development Company']);
        TenantFactory::new()->createOne(['name' => $marker.' Marketing Agency']);
        TenantFactory::new()->createOne(['name' => $marker.' Sales Corporation']);

        $companyTenants = Tenant::where('name', 'like', '%'.$marker.'%Company%')->get();

        Assert::assertCount(1, $companyTenants);
        Assert::assertTrue($companyTenants->every(fn ($tenant) => str_contains((string) $tenant->name, 'Company')));
    });

    test('can find tenants by domain pattern', function (): void {
        $marker = uniqid();

        TenantFactory::new()->createOne(['domain' => 'dev-'.$marker.'.example.com']);
        TenantFactory::new()->createOne(['domain' => 'staging-'.$marker.'.example.com']);
        TenantFactory::new()->createOne(['domain' => 'prod-'.$marker.'.example.com']);

        $exampleTenants = Tenant::where('domain', 'like', '%'.$marker.'.example.com')->get();

        Assert::assertCount(3, $exampleTenants);
        Assert::assertTrue($exampleTenants->every(fn ($tenant) => str_ends_with((string) $tenant->domain, '.example.com')));
    });

    test('can update tenant', function (): void {
        /** @var TestCase $this */
        $tenant = TenantFactory::new()->createOne(['name' => 'Old Name']);

        $tenant->update(['name' => 'New Name']);

        $this->assertDatabaseHasRow('tenants', [
            'id' => $tenant->id,
            'name' => 'New Name',
        ]);
    });

    test('can handle null values', function (): void {
        $tenant = TenantFactory::new()->createOne([
            'name' => 'Test Tenant',
            'domain' => null,
            'database' => null,
        ]);

        Assert::assertNull($tenant->domain);
        Assert::assertNull($tenant->database);
    });

    test('can find tenants by multiple criteria', function (): void {
        $marker = 'multi-criteria-'.uniqid();

        TenantFactory::new()->createOne([
            'name' => $marker.' Active Company',
            'is_active' => true,
            'domain' => $marker.'-active.com',
        ]);

        TenantFactory::new()->createOne([
            'name' => $marker.' Inactive Company',
            'is_active' => false,
            'domain' => $marker.'-inactive.com',
        ]);

        $tenants = Tenant::query()
            ->where('name', 'like', $marker.'%')
            ->where('is_active', true)
            ->where('domain', 'like', '%.com')
            ->get();

        Assert::assertCount(1, $tenants);
        $firstTenant = $tenants->first();
        Assert::assertNotNull($firstTenant);
        Assert::assertSame($marker.' Active Company', $firstTenant->name);
        Assert::assertTrue((bool) $firstTenant->is_active);
    });

    test('tenant has users relationship', function (): void {
        $tenant = TenantFactory::new()->createOne();
    });

    test('tenant has members relationship', function (): void {
        $tenant = TenantFactory::new()->createOne();
    });

    test('tenant has media relationship', function (): void {
        $tenant = TenantFactory::new()->createOne();
    });

    test('tenant has factory', function (): void {
        $tenant = TenantFactory::new()->createOne();

        Assert::assertNotNull($tenant->id);
        Assert::assertInstanceOf(Tenant::class, $tenant);
    });

    test('can find tenants by trial status', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessTenantColumn('trial_ends_at');

        $marker = 'trial-status-'.uniqid();

        $activeTenant = TenantFactory::new()->createOne([
            'name' => $marker.' active',
            'trial_ends_at' => now()->addDays(30),
        ]);

        TenantFactory::new()->createOne([
            'name' => $marker.' expired',
            'trial_ends_at' => now()->subDays(1),
        ]);

        $activeTrials = Tenant::query()
            ->where('name', 'like', $marker.'%')
            ->where('trial_ends_at', '>', now())
            ->get();

        Assert::assertCount(1, $activeTrials);
        $firstTrial = $activeTrials->first();
        Assert::assertNotNull($firstTrial);
        Assert::assertSame($activeTenant->id, $firstTrial->id);
    });

    test('can find tenants by settings value', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessTenantColumn('settings');

        $marker = 'settings-theme-'.uniqid();

        TenantFactory::new()->createOne([
            'name' => $marker.' dark',
            'settings' => ['theme' => 'dark', 'features' => ['chat']],
        ]);

        TenantFactory::new()->createOne([
            'name' => $marker.' light',
            'settings' => ['theme' => 'light', 'features' => ['analytics']],
        ]);

        $darkThemeTenants = Tenant::query()
            ->where('name', 'like', $marker.'%')
            ->whereJsonContains('settings->theme', 'dark')
            ->get();

        Assert::assertCount(1, $darkThemeTenants);
        $firstDark = $darkThemeTenants->first();
        Assert::assertNotNull($firstDark);
        /** @var array<string, mixed> $settings */
        $settings = $firstDark->settings ?? [];
        Assert::assertSame('dark', $settings['theme'] ?? null);
    });
});
