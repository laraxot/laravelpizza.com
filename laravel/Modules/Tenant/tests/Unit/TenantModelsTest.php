<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Models\Tenant;
use Modules\User\Models\User;

uses(TestCase::class)->in(__DIR__);

it('can create a tenant', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Test Company',
        'domain' => 'test.company.com',
        'database' => 'tenant_test_db',
    ]);

    expect($tenant)->toBeInstanceOf(Tenant::class);
    expect($tenant->name)->toBe('Test Company');
    expect($tenant->domain)->toBe('test.company.com');
    expect($tenant->database)->toBe('tenant_test_db');
});

it('can create a tenant with database configuration', function () {
    $tenant = Tenant::factory()->withDatabaseConfig()->create([
        'name' => 'Enterprise Tenant',
        'domain' => 'enterprise.example.com',
    ]);

    expect($tenant->database_config)->toBeInstanceOf(\Modules\Tenant\Models\DatabaseConfig::class);
    expect($tenant->database_config->host)->toBe('localhost');
});

it('can create a tenant domain', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Domain Tenant',
        'domain' => 'domain.example.com',
    ]);

    $domain = $tenant->domains()->create([
        'domain' => 'www.domain.example.com',
        'is_primary' => true,
    ]);

    expect($domain)->toBeInstanceOf(\Modules\Tenant\Models\Domain::class);
    expect($domain->is_primary)->toBeTrue();
    expect($domain->tenant_id)->toBe($tenant->id);
});

it('can create a tenant user', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'User Tenant',
        'domain' => 'user.example.com',
    ]);

    $user = User::factory()->forTenant($tenant)->create([
        'name' => 'Tenant User',
        'email' => 'user@tenant.example.com',
    ]);

    expect($user->tenant_id)->toBe($tenant->id);
    expect($user->tenant->name)->toBe('User Tenant');
});

it('can create a tenant subscription', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Subscription Tenant',
        'domain' => 'subscription.example.com',
    ]);

    $subscription = $tenant->subscriptions()->create([
        'plan' => 'premium',
        'starts_at' => now(),
        'ends_at' => now()->addMonth(),
    ]);

    expect($subscription)->toBeInstanceOf(\Modules\Tenant\Models\Subscription::class);
    expect($subscription->plan)->toBe('premium');
    expect($subscription->is_active)->toBeTrue();
});

it('can create a tenant setting', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Setting Tenant',
        'domain' => 'setting.example.com',
    ]);

    $setting = $tenant->settings()->create([
        'key' => 'app_name',
        'value' => 'My Application',
    ]);

    expect($setting)->toBeInstanceOf(\Modules\Tenant\Models\Setting::class);
    expect($setting->key)->toBe('app_name');
    expect($setting->value)->toBe('My Application');
});

it('can create a tenant audit log', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Audit Tenant',
        'domain' => 'audit.example.com',
    ]);

    $audit = $tenant->audits()->create([
        'user_id' => 1,
        'event' => 'tenant_created',
        'auditable_type' => Tenant::class,
        'auditable_id' => $tenant->id,
    ]);

    expect($audit)->toBeInstanceOf(\Modules\Tenant\Models\Audit::class);
    expect($audit->event)->toBe('tenant_created');
    expect($audit->auditable_type)->toBe(Tenant::class);
});

it('can create a tenant with multiple users', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Multi User Tenant',
        'domain' => 'multi.example.com',
    ]);

    $users = User::factory()->count(3)->forTenant($tenant)->create();

    expect($users->count())->toBe(3);
    expect($users->first()->tenant_id)->toBe($tenant->id);
});

it('can create a tenant with custom configuration', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Config Tenant',
        'domain' => 'config.example.com',
    ]);

    $config = $tenant->configs()->create([
        'key' => 'custom_config',
        'value' => json_encode(['theme' => 'dark', 'language' => 'it']),
    ]);

    expect($config)->toBeInstanceOf(\Modules\Tenant\Models\Config::class);
    expect($config->key)->toBe('custom_config');
    expect(json_decode($config->value, true)['theme'])->toBe('dark');
});