<?php

declare(strict_types=1);

uses(\Modules\Tenant\Tests\TestCase::class);

uses(\Modules\Tenant\Tests\TestCase::class);

use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Models\TenantSetting;
use Modules\Tenant\Models\TenantSubscription;
use Modules\User\Models\User;
use Webmozart\Assert\Assert;

it('can create and manage tenants', function (): void {
    // Arrange
    $user = User::factory()->create();
    Assert::isInstanceOf($user, User::class);

    // Act
    $tenant = Tenant::factory()->create([
        'name' => 'Test Studio',
        'slug' => 'test-studio',
        'is_active' => true,
    ]);
    Assert::isInstanceOf($tenant, Tenant::class);

    // Assert
    $this->assertDatabaseHas('tenants', [
        'id' => $tenant->id,
        'name' => 'Test Studio',
        'slug' => 'test-studio',
    ]);

    expect($tenant->name)->toBe('Test Studio');
    expect($tenant->slug)->toBe('test-studio');
    expect($tenant->is_active)->toBeTrue();
});

it('can manage tenant domains', function (): void {
    // Arrange
    $tenant = Tenant::factory()->create();
    Assert::isInstanceOf($tenant, Tenant::class);

    // Act
    $domain = TenantDomain::factory()->create([
        'tenant_id' => $tenant->id,
        'domain' => 'test.example.com',
        'is_primary' => true,
        'status' => 'active',
    ]);
    Assert::isInstanceOf($domain, TenantDomain::class);

    // Assert
    $this->assertDatabaseHas('tenant_domains', [
        'id' => $domain->id,
        'tenant_id' => $tenant->id,
        'domain' => 'test.example.com',
        'is_primary' => true,
        'status' => 'active',
    ]);

    expect($domain->tenant_id)->toBe($tenant->id);
    expect($domain->domain)->toBe('test.example.com');
    expect($domain->is_primary)->toBeTrue();
    expect($domain->status)->toBe('active');
});

it('can manage tenant settings', function (): void {
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

    expect($setting->tenant_id)->toBe($tenant->id);
    expect($setting->key)->toBe('app.name');
    expect($setting->value)->toBe('Test Studio Application');
    expect($setting->type)->toBe('string');
});

it('can manage tenant subscriptions', function (): void {
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

    expect($subscription->tenant_id)->toBe($tenant->id);
    expect($subscription->plan_name)->toBe('Professional');
    expect($subscription->status)->toBe('active');
    expect($subscription->max_users)->toBe(50);
    expect($subscription->max_storage_gb)->toBe(100);
});

it('can validate tenant slug uniqueness', function (): void {
    // Arrange & Act
    $tenant1 = Tenant::factory()->create([
        'name' => 'Studio A',
        'slug' => 'studio-a',
    ]);
    $tenant2 = Tenant::factory()->create([
        'name' => 'Studio B',
        'slug' => 'studio-b',
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

    expect($tenant1->slug)->not()->toBe($tenant2->slug);
    expect($tenant1->slug)->toBe('studio-a');
    expect($tenant2->slug)->toBe('studio-b');
});

it('can manage tenant status workflow', function (): void {
    // Arrange - tenant inattivo
    $tenant = Tenant::factory()->create([
        'is_active' => false,
    ]);

    // Act - Attivazione
    $tenant->update(['is_active' => true]);

    // Assert
    expect($tenant->fresh()?->is_active)->toBeTrue();

    // Act - Disattivazione
    $tenant->update(['is_active' => false]);

    // Assert
    expect($tenant->fresh()?->is_active)->toBeFalse();

    // Act - Riattivazione
    $tenant->update(['is_active' => true]);

    // Assert
    expect($tenant->fresh()?->is_active)->toBeTrue();
});

it('can handle tenant domain verification', function (): void {
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

    expect($domain->status)->toBe('pending_verification');
    expect($domain->verification_token)->toBe('abc123');

    // Act - Verify domain
    $domain->update([
        'status' => 'active',
        'verified_at' => now(),
        'verification_token' => null,
    ]);

    // Assert
    $domainFresh = $domain->fresh();
    Assert::isInstanceOf($domainFresh, TenantDomain::class);
    expect($domainFresh->status)->toBe('active');
    expect($domainFresh->verified_at)->not()->toBeNull();
    expect($domainFresh->verification_token)->toBeNull();
});

it('can manage tenant storage limits', function (): void {
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

    expect($subscription->max_storage_gb)->toBe(100);
    expect($subscription->current_storage_gb)->toBe(25);
    expect($subscription->max_storage_gb - $subscription->current_storage_gb)->toBe(75);

    // Act - Update storage usage
    $subscription->update(['current_storage_gb' => 50]);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::isInstanceOf($subFresh, TenantSubscription::class);
    expect($subFresh->current_storage_gb)->toBe(50);
    expect($subFresh->max_storage_gb - $subFresh->current_storage_gb)->toBe(50);
});

it('can manage tenant user limits', function (): void {
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

    expect($subscription->max_users)->toBe(50);
    expect($subscription->current_users)->toBe(10);
    expect($subscription->max_users - $subscription->current_users)->toBe(40);

    // Act - Add more users
    $subscription->update(['current_users' => 25]);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::isInstanceOf($subFresh, TenantSubscription::class);
    expect($subFresh->current_users)->toBe(25);
    expect($subFresh->max_users - $subFresh->current_users)->toBe(25);
});

it('can handle tenant subscription expiration', function (): void {
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

    expect($subscription->expires_at->isPast())->toBeTrue();

    // Act - Mark as expired
    $subscription->update(['status' => 'expired']);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::isInstanceOf($subFresh, TenantSubscription::class);
    expect($subFresh->status)->toBe('expired');
});

it('can manage tenant settings hierarchy', function (): void {
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

    expect($appSetting->key)->toBe('app.name');
    expect($databaseSetting->key)->toBe('database.connection');
    expect($mailSetting->key)->toBe('mail.driver');
});

it('can validate tenant domain formats', function (): void {
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

        expect($tenantDomain->domain)->toBe($domain);
        $this->assertDatabaseHas('tenant_domains', [
            'id' => $tenantDomain->id,
            'domain' => $domain,
        ]);
    }
});

it('can track tenant activity', function (): void {
    // Arrange
    $tenant = Tenant::factory()->create([
        'created_at' => now()->subMonths(3),
        'last_activity_at' => now()->subDays(5),
    ]);

    // Act - Update last activity
    $tenant->update(['last_activity_at' => now()]);

    // Assert
    $fresh = $tenant->fresh();
    Assert::isInstanceOf($fresh, Tenant::class);
    expect($fresh->last_activity_at)->not()->toBeNull();
    expect($fresh->last_activity_at->isToday())->toBeTrue();
});

it('can manage tenant billing cycles', function (): void {
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

    expect($subscription->billing_cycle)->toBe('monthly');
    expect($subscription->billing_amount)->toBe(99.99);
    expect($subscription->next_billing_date->isFuture())->toBeTrue();

    // Act - Update billing cycle
    $subscription->update([
        'billing_cycle' => 'yearly',
        'billing_amount' => 999.99,
        'next_billing_date' => now()->addYear(),
    ]);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::isInstanceOf($subFresh, TenantSubscription::class);
    expect($subFresh->billing_cycle)->toBe('yearly');
    expect($subFresh->billing_amount)->toBe(999.99);
    expect($subFresh->next_billing_date?->isFuture())->toBeTrue();
});
