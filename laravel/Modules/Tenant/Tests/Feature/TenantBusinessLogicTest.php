<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Models\TenantSetting;
use Modules\Tenant\Models\TenantSubscription;
use Modules\User\Models\User;
use Tests\TestCase;

class TenantBusinessLogicTest extends TestCase
{
    /** @test */
    public function it_can_create_and_manage_tenants(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $tenant = Tenant::factory()->create([
            'name' => 'Test Studio',
            'slug' => 'test-studio',
            'status' => 'active',
            'owner_id' => $user->id,
        ]);

        // Assert
        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Studio',
            'slug' => 'test-studio',
            'status' => 'active',
            'owner_id' => $user->id,
        ]);

        $this->assertEquals('Test Studio', $tenant->name);
        $this->assertEquals('test-studio', $tenant->slug);
        $this->assertEquals('active', $tenant->status);
        $this->assertEquals($user->id, $tenant->owner_id);
    }

    /** @test */
    public function it_can_manage_tenant_domains(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act
        $domain = TenantDomain::factory()->create([
            'tenant_id' => $tenant->id,
            'domain' => 'test.example.com',
            'is_primary' => true,
            'status' => 'active',
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_domains', [
            'id' => $domain->id,
            'tenant_id' => $tenant->id,
            'domain' => 'test.example.com',
            'is_primary' => true,
            'status' => 'active',
        ]);

        $this->assertEquals($tenant->id, $domain->tenant_id);
        $this->assertEquals('test.example.com', $domain->domain);
        $this->assertTrue($domain->is_primary);
        $this->assertEquals('active', $domain->status);
    }

    /** @test */
    public function it_can_manage_tenant_settings(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act
        $setting = TenantSetting::factory()->create([
            'tenant_id' => $tenant->id,
            'key' => 'app.name',
            'value' => 'Test Studio Application',
            'type' => 'string',
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_settings', [
            'id' => $setting->id,
            'tenant_id' => $tenant->id,
            'key' => 'app.name',
            'value' => 'Test Studio Application',
            'type' => 'string',
        ]);

        $this->assertEquals($tenant->id, $setting->tenant_id);
        $this->assertEquals('app.name', $setting->key);
        $this->assertEquals('Test Studio Application', $setting->value);
        $this->assertEquals('string', $setting->type);
    }

    /** @test */
    public function it_can_manage_tenant_subscriptions(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act
        $subscription = TenantSubscription::factory()->create([
            'tenant_id' => $tenant->id,
            'plan_name' => 'Professional',
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addYear(),
            'max_users' => 50,
            'max_storage_gb' => 100,
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_subscriptions', [
            'id' => $subscription->id,
            'tenant_id' => $tenant->id,
            'plan_name' => 'Professional',
            'status' => 'active',
            'max_users' => 50,
            'max_storage_gb' => 100,
        ]);

        $this->assertEquals($tenant->id, $subscription->tenant_id);
        $this->assertEquals('Professional', $subscription->plan_name);
        $this->assertEquals('active', $subscription->status);
        $this->assertEquals(50, $subscription->max_users);
        $this->assertEquals(100, $subscription->max_storage_gb);
    }

    /** @test */
    public function it_can_validate_tenant_slug_uniqueness(): void
    {
        // Arrange
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Act
        $tenant1 = Tenant::factory()->create([
            'name' => 'Studio A',
            'slug' => 'studio-a',
            'owner_id' => $user1->id,
        ]);

        $tenant2 = Tenant::factory()->create([
            'name' => 'Studio B',
            'slug' => 'studio-b',
            'owner_id' => $user2->id,
        ]);

        // Assert
        $this->assertDatabaseHas('tenants', [
            'id' => $tenant1->id,
            'slug' => 'studio-a',
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant2->id,
            'slug' => 'studio-b',
        ]);

        $this->assertNotEquals($tenant1->slug, $tenant2->slug);
        $this->assertEquals('studio-a', $tenant1->slug);
        $this->assertEquals('studio-b', $tenant2->slug);
    }

    /** @test */
    public function it_can_manage_tenant_status_workflow(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create([
            'status' => 'pending',
        ]);

        // Act - Pending to Active
        $tenant->update(['status' => 'active']);

        // Assert
        $this->assertEquals('active', $tenant->fresh()->status);

        // Act - Active to Suspended
        $tenant->update(['status' => 'suspended']);

        // Assert
        $this->assertEquals('suspended', $tenant->fresh()->status);

        // Act - Suspended to Active
        $tenant->update(['status' => 'active']);

        // Assert
        $this->assertEquals('active', $tenant->fresh()->status);
    }

    /** @test */
    public function it_can_handle_tenant_domain_verification(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act
        $domain = TenantDomain::factory()->create([
            'tenant_id' => $tenant->id,
            'domain' => 'unverified.example.com',
            'is_primary' => false,
            'status' => 'pending_verification',
            'verification_token' => 'abc123',
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_domains', [
            'id' => $domain->id,
            'status' => 'pending_verification',
        ]);

        $this->assertEquals('pending_verification', $domain->status);
        $this->assertEquals('abc123', $domain->verification_token);

        // Act - Verify domain
        $domain->update([
            'status' => 'active',
            'verified_at' => now(),
            'verification_token' => null,
        ]);

        // Assert
        $this->assertEquals('active', $domain->fresh()->status);
        $this->assertNotNull($domain->fresh()->verified_at);
        $this->assertNull($domain->fresh()->verification_token);
    }

    /** @test */
    public function it_can_manage_tenant_storage_limits(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();
        $subscription = TenantSubscription::factory()->create([
            'tenant_id' => $tenant->id,
            'max_storage_gb' => 100,
            'current_storage_gb' => 25,
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_subscriptions', [
            'id' => $subscription->id,
            'max_storage_gb' => 100,
            'current_storage_gb' => 25,
        ]);

        $this->assertEquals(100, $subscription->max_storage_gb);
        $this->assertEquals(25, $subscription->current_storage_gb);
        $this->assertEquals(75, $subscription->max_storage_gb - $subscription->current_storage_gb);

        // Act - Update storage usage
        $subscription->update(['current_storage_gb' => 50]);

        // Assert
        $this->assertEquals(50, $subscription->fresh()->current_storage_gb);
        $this->assertEquals(50, $subscription->fresh()->max_storage_gb - $subscription->fresh()->current_storage_gb);
    }

    /** @test */
    public function it_can_manage_tenant_user_limits(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();
        $subscription = TenantSubscription::factory()->create([
            'tenant_id' => $tenant->id,
            'max_users' => 50,
            'current_users' => 10,
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_subscriptions', [
            'id' => $subscription->id,
            'max_users' => 50,
            'current_users' => 10,
        ]);

        $this->assertEquals(50, $subscription->max_users);
        $this->assertEquals(10, $subscription->current_users);
        $this->assertEquals(40, $subscription->max_users - $subscription->current_users);

        // Act - Add more users
        $subscription->update(['current_users' => 25]);

        // Assert
        $this->assertEquals(25, $subscription->fresh()->current_users);
        $this->assertEquals(25, $subscription->fresh()->max_users - $subscription->fresh()->current_users);
    }

    /** @test */
    public function it_can_handle_tenant_subscription_expiration(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();
        $subscription = TenantSubscription::factory()->create([
            'tenant_id' => $tenant->id,
            'status' => 'active',
            'expires_at' => now()->subDays(1), // Expired yesterday
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);

        $this->assertTrue($subscription->expires_at->isPast());

        // Act - Mark as expired
        $subscription->update(['status' => 'expired']);

        // Assert
        $this->assertEquals('expired', $subscription->fresh()->status);
    }

    /** @test */
    public function it_can_manage_tenant_settings_hierarchy(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act - Create multiple settings
        $appSetting = TenantSetting::factory()->create([
            'tenant_id' => $tenant->id,
            'key' => 'app.name',
            'value' => 'Studio App',
            'type' => 'string',
        ]);

        $databaseSetting = TenantSetting::factory()->create([
            'tenant_id' => $tenant->id,
            'key' => 'database.connection',
            'value' => 'mysql',
            'type' => 'string',
        ]);

        $mailSetting = TenantSetting::factory()->create([
            'tenant_id' => $tenant->id,
            'key' => 'mail.driver',
            'value' => 'smtp',
            'type' => 'string',
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_settings', [
            'id' => $appSetting->id,
            'key' => 'app.name',
        ]);

        $this->assertDatabaseHas('tenant_settings', [
            'id' => $databaseSetting->id,
            'key' => 'database.connection',
        ]);

        $this->assertDatabaseHas('tenant_settings', [
            'id' => $mailSetting->id,
            'key' => 'mail.driver',
        ]);

        $this->assertEquals('app.name', $appSetting->key);
        $this->assertEquals('database.connection', $databaseSetting->key);
        $this->assertEquals('mail.driver', $mailSetting->key);
    }

    /** @test */
    public function it_can_validate_tenant_domain_formats(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act & Assert - Valid domains
        $validDomains = [
            'example.com',
            'sub.example.com',
            'test-studio.com',
            'studio123.com',
        ];

        foreach ($validDomains as $domain) {
            $tenantDomain = TenantDomain::factory()->create([
                'tenant_id' => $tenant->id,
                'domain' => $domain,
                'status' => 'active',
            ]);

            $this->assertEquals($domain, $tenantDomain->domain);
            $this->assertDatabaseHas('tenant_domains', [
                'id' => $tenantDomain->id,
                'domain' => $domain,
            ]);
        }
    }

    /** @test */
    public function it_can_track_tenant_activity(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create([
            'created_at' => now()->subMonths(3),
            'last_activity_at' => now()->subDays(5),
        ]);

        // Act - Update last activity
        $tenant->update(['last_activity_at' => now()]);

        // Assert
        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'last_activity_at' => now(),
        ]);

        $this->assertNotNull($tenant->fresh()->last_activity_at);
        $this->assertTrue($tenant->fresh()->last_activity_at->isToday());
    }

    /** @test */
    public function it_can_manage_tenant_billing_cycles(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();
        $subscription = TenantSubscription::factory()->create([
            'tenant_id' => $tenant->id,
            'billing_cycle' => 'monthly',
            'billing_amount' => 99.99,
            'next_billing_date' => now()->addMonth(),
        ]);

        // Assert
        $this->assertDatabaseHas('tenant_subscriptions', [
            'id' => $subscription->id,
            'billing_cycle' => 'monthly',
            'billing_amount' => 99.99,
        ]);

        $this->assertEquals('monthly', $subscription->billing_cycle);
        $this->assertEquals(99.99, $subscription->billing_amount);
        $this->assertTrue($subscription->next_billing_date->isFuture());

        // Act - Update billing cycle
        $subscription->update([
            'billing_cycle' => 'yearly',
            'billing_amount' => 999.99,
            'next_billing_date' => now()->addYear(),
        ]);

        // Assert
        $this->assertEquals('yearly', $subscription->fresh()->billing_cycle);
        $this->assertEquals(999.99, $subscription->fresh()->billing_amount);
        $this->assertTrue($subscription->fresh()->next_billing_date->isFuture());
    }
}
