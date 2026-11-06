<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;
use Webmozart\Assert\Assert as WebmozartAssert;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    if (TestCase::tenantDbUnavailable()) {
        $this->skipTest('DB `tenant` non raggiungibile: blocco di ambiente.');
    }
});

it('can create a tenant', function (): void {
    $tenant = TestCase::createTenant([
        'name' => 'Test Company',
        'domain' => 'test.company.com',
        'database' => 'tenant_test_db',
    ]);

    Assert::assertSame('Test Company', $tenant->name);
    Assert::assertSame('test.company.com', $tenant->domain);
    Assert::assertSame('tenant_test_db', $tenant->database);
});

it('can create a tenant with settings', function (): void {
    /** @var TestCase $this */
    try {
        $schema = DB::connection('tenant')->getSchemaBuilder();
        if (! $schema->hasColumn('tenants', 'settings')) {
            $this->skipTest('Colonna tenants.settings assente sullo schema condiviso.');
        }
    } catch (\Throwable) {
        $this->skipTest('Schema tenant non ispezionabile.');
    }

    /** @var TenantFactory $factory */
    $factory = Tenant::factory();
    $tenant = $factory->withSettings(['locale' => 'it', 'timezone' => 'Europe/Rome'])->create([
        'name' => 'Settings Tenant',
        'domain' => 'settings.example.com',
    ]);
    WebmozartAssert::isInstanceOf($tenant, Tenant::class);

    Assert::assertIsArray($tenant->settings);
    Assert::assertSame('it', $tenant->settings['locale'] ?? null);
});

it('exposes users relationship', function (): void {
    $tenant = TestCase::createTenant([
        'name' => 'User Tenant',
        'domain' => 'user.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $user = $userFactory->create([
        'name' => 'Tenant User',
        'email' => 'user@tenant.example.com',
    ]);
    WebmozartAssert::isInstanceOf($user, UserContract::class);
    WebmozartAssert::isInstanceOf($user, Model::class);

    $tenant->users()->save($user);

    Assert::assertTrue($tenant->users()->whereKey($user->id)->exists());
});

it('can create multiple users for a tenant', function (): void {
    $tenant = TestCase::createTenant([
        'name' => 'Multi User Tenant',
        'domain' => 'multi.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $users = $userFactory->count(3)->create();
    foreach ($users->all() as $user) {
        $tenant->users()->save($user);
    }

    Assert::assertSame(3, $tenant->users()->count());
});

it('reports active state via isActive', function (): void {
    $active = TestCase::createTenant(['is_active' => true]);
    $inactive = TestCase::createTenant(['is_active' => false]);

    Assert::assertTrue($active->isActive());
    Assert::assertFalse($inactive->isActive());
});
