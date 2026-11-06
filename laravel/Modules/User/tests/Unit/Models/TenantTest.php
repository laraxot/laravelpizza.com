<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Modules\User\Models\Tenant;
use Mockery\MockInterface;
use Tests\TestCase;

use function Safe\json_encode;

uses(\Modules\User\Tests\TestCase::class);

class TenantTest extends TestCase
{
    public function test_can_create_tenant_with_minimal_data(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant',
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Tenant',
        ]);
    }

    public function test_can_create_tenant_with_all_fields(): void
    {
        $tenantData = [
            'name' => 'Full Tenant',
            'slug' => 'full-tenant',
            'domain' => 'fulltenant.com',
            'database' => 'fulltenant_db',
            'settings' => ['theme' => 'dark', 'features' => ['chat', 'analytics']],
            'is_active' => true,
            'trial_ends_at' => now()->addDays(30),
        ];

        $tenant = Tenant::factory()->create($tenantData);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Full Tenant',
            'slug' => 'full-tenant',
            'domain' => 'fulltenant.com',
            'database' => 'fulltenant_db',
            'is_active' => true,
        ]);

        // Verifica campi JSON
        static::assertSame(['theme' => 'dark', 'features' => ['chat', 'analytics']], $tenant->settings);
    }

    public function test_tenant_has_soft_deletes(): void
    {
        $this->markTestSkipped('Tenant model does not use SoftDeletes.');
    }

    public function test_can_restore_soft_deleted_tenant(): void
    {
        $this->markTestSkipped('Tenant model does not use SoftDeletes.');
    }

    public function test_can_find_tenant_by_name(): void
    {
        $tenant = Tenant::factory()->create(['name' => 'Unique Tenant Name']);

        $foundTenant = Tenant::where('name', 'Unique Tenant Name')->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function test_can_find_tenant_by_slug(): void
    {
        $tenant = Tenant::factory()->create(['slug' => 'unique-tenant']);

        $foundTenant = Tenant::where('slug', 'unique-tenant')->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function test_can_find_tenant_by_domain(): void
    {
        $tenant = Tenant::factory()->create(['domain' => 'uniquetenant.com']);

        $foundTenant = Tenant::where('domain', 'uniquetenant.com')->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function test_can_find_tenant_by_database(): void
    {
        $tenant = Tenant::factory()->create(['database' => 'unique_db']);

        $foundTenant = Tenant::where('database', 'unique_db')->first();

        static::assertNotNull($foundTenant);
        static::assertSame($tenant->id, $foundTenant->id);
    }

    public function test_can_find_active_tenants(): void
    {
        Tenant::factory()->create(['is_active' => true]);
        Tenant::factory()->create(['is_active' => false]);
        Tenant::factory()->create(['is_active' => true]);

        $activeTenants = Tenant::where('is_active', true)->get();

        static::assertCount(2, $activeTenants);
        static::assertTrue($activeTenants->every(fn (Tenant $tenant): bool => (bool) $tenant->is_active));
    }

    public function test_can_find_tenants_by_name_pattern(): void
    {
        Tenant::factory()->create(['name' => 'Development Company']);
        Tenant::factory()->create(['name' => 'Marketing Agency']);
        Tenant::factory()->create(['name' => 'Sales Corporation']);

        $companyTenants = Tenant::where('name', 'like', '%Company%')->get();

        static::assertCount(1, $companyTenants);
        static::assertTrue($companyTenants->every(fn (Tenant $tenant): bool => str_contains($tenant->name, 'Company')));
    }

    public function test_can_find_tenants_by_domain_pattern(): void
    {
        Tenant::factory()->create(['domain' => 'dev.example.com']);
        Tenant::factory()->create(['domain' => 'staging.example.com']);
        Tenant::factory()->create(['domain' => 'prod.example.com']);

        $exampleTenants = Tenant::where('domain', 'like', '%.example.com')->get();

        static::assertCount(3, $exampleTenants);
        static::assertTrue($exampleTenants->every(fn (Tenant $tenant): bool => str_ends_with((string) $tenant->domain, '.example.com')));
    }

    public function test_can_update_tenant(): void
    {
        $tenant = Tenant::factory()->create(['name' => 'Old Name']);

        $tenant->update(['name' => 'New Name']);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_handle_null_values(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant',
            'slug' => null,
            'domain' => null,
            'database' => null,
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'slug' => null,
            'domain' => null,
            'database' => null,
        ]);
    }

    public function test_can_find_tenants_by_multiple_criteria(): void
    {
        Tenant::factory()->create([
            'name' => 'Active Company',
            'is_active' => true,
            'domain' => 'active.com',
        ]);

        Tenant::factory()->create([
            'name' => 'Inactive Company',
            'is_active' => false,
            'domain' => 'inactive.com',
        ]);

        $tenants = Tenant::where('is_active', true)->where('domain', 'like', '%.com')->get();

        static::assertCount(1, $tenants);
        static::assertSame('Active Company', $tenants->firstOrFail()->name);
        static::assertTrue((bool) $tenants->firstOrFail()->is_active);
    }

    public function test_tenant_has_users_relationship(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertInstanceOf(BelongsToMany::class, $tenant->users());
    }

    public function test_tenant_has_members_relationship(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertInstanceOf(BelongsToMany::class, $tenant->members());
    }

    public function test_tenant_has_media_relationship(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertInstanceOf(MorphMany::class, $tenant->media());
    }

    public function test_tenant_has_factory(): void
    {
        $tenant = Tenant::factory()->create();

        static::assertNotNull($tenant->id);
        static::assertInstanceOf(Tenant::class, $tenant);
    }

    public function test_can_find_tenants_by_trial_status(): void
    {
        $activeTenant = Tenant::factory()->create([
            'trial_ends_at' => now()->addDays(30),
        ]);

        Tenant::factory()->create([
            'trial_ends_at' => now()->subDays(1),
        ]);

        $activeTrials = Tenant::where('trial_ends_at', '>', now())->get();

        static::assertCount(1, $activeTrials);
        static::assertSame($activeTenant->id, $activeTrials->firstOrFail()->id);
    }

    public function test_can_find_tenants_by_settings_value(): void
    {
        // `tenants.settings` e' una colonna json (migration 2026_09_01_150110) ma il model
        // non ha il cast `array`: si scrive il json a mano e si cerca per id.
        $darkTenant = Tenant::factory()->create([
            'settings' => json_encode(['theme' => 'dark', 'features' => ['chat']]),
        ]);

        Tenant::factory()->create([
            'settings' => json_encode(['theme' => 'light', 'features' => ['analytics']]),
        ]);

        $darkThemeTenants = Tenant::whereJsonContains('settings->theme', 'dark')->get();

        static::assertCount(1, $darkThemeTenants);
        static::assertSame($darkTenant->id, $darkThemeTenants->firstOrFail()->id);
    }

    public function test_resolve_route_binding_query_preserve_slug_per_has_slug(): void
    {
        $tenant = new Tenant();

        /** @var list<array{string, string|int}> $calls */
        $calls = [];
        /** @var Builder<Model>&MockInterface $query */
        $query = \Mockery::mock(Builder::class);
        $query->shouldReceive('where')->andReturnUsing(
            function ($field, $value) use (&$calls, $query) {
                $calls[] = [$field, $value];

                return $query;
            }
        );

        $result = $tenant->resolveRouteBindingQuery($query, 'my-tenant', 'slug');

        static::assertSame($query, $result);
        $this->assertSame([['slug', 'my-tenant']], $calls);
    }

    public function test_resolve_route_binding_query_uses_id_for_non_uuid_value(): void
    {
        $tenant = new Tenant();

        /** @var list<array{string, string|int}> $calls */
        $calls = [];
        /** @var Builder<Model>&MockInterface $query */
        $query = \Mockery::mock(Builder::class);
        $query->shouldReceive('where')->andReturnUsing(
            function ($field, $value) use (&$calls, $query) {
                $calls[] = [$field, $value];

                return $query;
            }
        );

        $result = $tenant->resolveRouteBindingQuery($query, 'not-a-uuid', 'id');

        static::assertSame($query, $result);
        $this->assertSame([['id', 'not-a-uuid']], $calls);
    }

    public function test_resolve_route_binding_query_accetta_uuid_valido_sulla_chiave_univoca(): void
    {
        $tenant = new Tenant();

        $uuid = (string) Str::uuid();

        /** @var list<array{string, string|int}> $calls */
        $calls = [];
        /** @var Builder<Model>&MockInterface $query */
        $query = \Mockery::mock(Builder::class);
        $query->shouldReceive('where')->andReturnUsing(
            function ($field, $value) use (&$calls, $query) {
                $calls[] = [$field, $value];

                return $query;
            }
        );

        $result = $tenant->resolveRouteBindingQuery($query, $uuid, 'id');

        static::assertSame($query, $result);
        $this->assertSame([['id', $uuid]], $calls);
    }
}
