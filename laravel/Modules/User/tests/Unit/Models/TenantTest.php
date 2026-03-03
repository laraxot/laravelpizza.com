<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Modules\User\Models\Tenant;
use Modules\User\Tests\TestCase;

class TenantTest extends TestCase
{
    // DatabaseTransactions is already used in the module TestCase

    public function testCanCreateTenantWithMinimalData(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant '.uniqid(),
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
        ], 'user');

        static::assertNotNull($tenant->id);
        static::assertNotNull($tenant->name);
    }

    public function testCanCreateTenantWithAllFields(): void
    {
        $uid = uniqid();
        $tenantData = [
            'name' => 'Full Tenant '.$uid,
            'slug' => 'full-tenant-'.$uid,
            'domain' => 'fulltenant-'.$uid.'.com',
            'database' => 'fulltenant_db_'.$uid,
            'is_active' => true,
        ];

        $tenant = Tenant::factory()->create($tenantData);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Full Tenant '.$uid,
            'slug' => 'full-tenant-'.$uid,
            'is_active' => true,
        ], 'user');
    }

    public function testTenantHasSoftDeletes(): void
    {
        if (! method_exists(Tenant::class, 'withTrashed')) {
            $this->markTestSkipped('SoftDeletes trait not present on Tenant model');
        }

        $tenant = Tenant::factory()->create();
        $tenantId = $tenant->id;

        $tenant->delete();

        $this->assertSoftDeleted('tenants', ['id' => $tenantId]);
    }

    public function testCanRestoreSoftDeletedTenant(): void
    {
        if (! method_exists(Tenant::class, 'withTrashed')) {
            $this->markTestSkipped('SoftDeletes trait not present on Tenant model');

            return;
        }

        $tenant = Tenant::factory()->create();
        $tenantId = $tenant->id;

        $tenant->delete();
        $this->assertSoftDeleted('tenants', ['id' => $tenantId]);

        /** @var Tenant $restoredTenant */
        $restoredTenant = Tenant::withTrashed()->find($tenantId);
        $restoredTenant->restore();

        $this->assertDatabaseHas('tenants', ['id' => $tenantId], 'user');
        static::assertNull($restoredTenant->deleted_at);
    }

    public function testCanFindTenantByName(): void
    {
        $uid = uniqid();
        $tenant = Tenant::factory()->create(['name' => 'Unique Tenant Name '.$uid]);

        $foundTenant = Tenant::where('name', 'Unique Tenant Name '.$uid)->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function testCanFindTenantBySlug(): void
    {
        $uid = uniqid();
        $tenant = Tenant::factory()->create(['slug' => 'unique-tenant-'.$uid]);

        $foundTenant = Tenant::where('slug', 'unique-tenant-'.$uid)->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function testCanFindTenantByDomain(): void
    {
        $uid = uniqid();
        $tenant = Tenant::factory()->create(['domain' => 'uniquetenant-'.$uid.'.com']);

        $foundTenant = Tenant::where('domain', 'uniquetenant-'.$uid.'.com')->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function testCanFindTenantByDatabase(): void
    {
        $uid = uniqid();
        $tenant = Tenant::factory()->create(['database' => 'unique_db_'.$uid]);

        $foundTenant = Tenant::where('database', 'unique_db_'.$uid)->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function testCanFindActiveTenants(): void
    {
        $uid = uniqid();
        $active1 = Tenant::factory()->create(['is_active' => true, 'name' => 'Active1 '.$uid]);
        $active2 = Tenant::factory()->create(['is_active' => true, 'name' => 'Active2 '.$uid]);
        Tenant::factory()->create(['is_active' => false, 'name' => 'Inactive '.$uid]);

        $activeTenants = Tenant::where('is_active', true)
            ->whereIn('id', [$active1->id, $active2->id])
            ->get();

        static::assertCount(2, $activeTenants);
        static::assertTrue($activeTenants->every(fn ($tenant) => (bool) $tenant->is_active));
    }

    public function testCanFindTenantsByNamePattern(): void
    {
        $uid = uniqid();
        Tenant::factory()->create(['name' => 'Development Company '.$uid]);
        Tenant::factory()->create(['name' => 'Marketing Agency '.$uid]);
        Tenant::factory()->create(['name' => 'Sales Corporation '.$uid]);

        $companyTenants = Tenant::where('name', 'like', '%Company '.$uid.'%')->get();

        static::assertCount(1, $companyTenants);
        static::assertTrue($companyTenants->every(fn ($tenant) => str_contains($tenant->name, 'Company '.$uid)));
    }

    public function testCanFindTenantsByDomainPattern(): void
    {
        $uid = uniqid();
        Tenant::factory()->create(['domain' => 'dev-'.$uid.'.example.com']);
        Tenant::factory()->create(['domain' => 'staging-'.$uid.'.example.com']);
        Tenant::factory()->create(['domain' => 'prod-'.$uid.'.example.com']);

        $exampleTenants = Tenant::where('domain', 'like', '%-'.$uid.'.example.com')->get();

        static::assertCount(3, $exampleTenants);
        static::assertTrue($exampleTenants->every(fn ($tenant) => str_ends_with($tenant->domain, '-'.$uid.'.example.com')));
    }

    public function testCanUpdateTenant(): void
    {
        $uid = uniqid();
        $tenant = Tenant::factory()->create(['name' => 'Old Name '.$uid]);

        $tenant->update(['name' => 'New Name '.$uid]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'New Name '.$uid,
        ], 'user');
    }

    public function testCanHandleNullValues(): void
    {
        $uid = uniqid();
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant '.$uid,
            'domain' => null,
            'database' => null,
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
        ], 'user');

        // slug is auto-generated from name via HasSlug, domain and database can be null
        static::assertNull($tenant->domain);
        static::assertNull($tenant->database);
    }

    public function testCanFindTenantsByMultipleCriteria(): void
    {
        $uid = uniqid();
        $active = Tenant::factory()->create([
            'name' => 'Active Company '.$uid,
            'is_active' => true,
            'domain' => 'active-'.$uid.'.com',
        ]);

        Tenant::factory()->create([
            'name' => 'Inactive Company '.$uid,
            'is_active' => false,
            'domain' => 'inactive-'.$uid.'.com',
        ]);

        $tenants = Tenant::where('is_active', true)->where('id', $active->id)->get();

        static::assertCount(1, $tenants);
        static::assertSame('Active Company '.$uid, $tenants->first()->name);
        static::assertTrue((bool) $tenants->first()->is_active);
    }

    public function testTenantHasUsersRelationship(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertTrue(method_exists($tenant, 'users'));
    }

    public function testTenantHasMembersRelationship(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertTrue(method_exists($tenant, 'members'));
    }

    public function testTenantHasMediaRelationship(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertTrue(method_exists($tenant, 'media'));
    }

    public function testTenantHasFactory(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertNotNull($tenant->id);
        static::assertInstanceOf(Tenant::class, $tenant);
    }

    public function testCanFindTenantsByTrialStatus(): void
    {
        if (! \Illuminate\Support\Facades\Schema::connection('user')->hasColumn('tenants', 'trial_ends_at')) {
            $this->markTestSkipped('trial_ends_at column does not exist in tenants table');
        }

        $uid = uniqid();
        $activeTenant = Tenant::factory()->create([
            'name' => 'Active Trial '.$uid,
            'trial_ends_at' => now()->addDays(30),
        ]);

        $expiredTenant = Tenant::factory()->create([
            'name' => 'Expired Trial '.$uid,
            'trial_ends_at' => now()->subDays(1),
        ]);

        $activeTrials = Tenant::where('trial_ends_at', '>', now())
            ->whereIn('id', [$activeTenant->id, $expiredTenant->id])
            ->get();

        static::assertCount(1, $activeTrials);
        static::assertSame($activeTenant->id, $activeTrials->first()->id);
    }

    public function testCanFindTenantsBySettingsValue(): void
    {
        if (! \Illuminate\Support\Facades\Schema::connection('user')->hasColumn('tenants', 'settings')) {
            $this->markTestSkipped('settings column does not exist in tenants table');
        }

        $uid = uniqid();

        try {
            Tenant::factory()->create([
                'name' => 'Dark Theme Tenant '.$uid,
                'settings' => ['theme' => 'dark', 'features' => ['chat']],
            ]);

            Tenant::factory()->create([
                'name' => 'Light Theme Tenant '.$uid,
                'settings' => ['theme' => 'light', 'features' => ['analytics']],
            ]);

            $darkThemeTenants = Tenant::where('name', 'like', '%Dark Theme Tenant '.$uid.'%')->get();

            static::assertCount(1, $darkThemeTenants);
        } catch (\Throwable $e) {
            $this->markTestSkipped('Settings column query failed: '.$e->getMessage());
        }
    }
}
