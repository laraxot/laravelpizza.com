<?php

declare(strict_types=1);

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Contracts\TenantContract;
use Modules\User\Database\Factories\TenantFactory;
use Modules\User\Models\BaseTenant;
use Modules\User\Models\Tenant;
use PHPUnit\Framework\Assert;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $overrides
 */
function createPersistedTenant(array $overrides = []): Tenant
{
    $tenant = new Tenant();
    $tenant->incrementing = false;
    $tenant->setKeyType('string');

    $tenant->fill(array_merge([
        'id' => (string) Str::uuid(),
        'name' => 'Test Tenant '.uniqid(),
        'email_address' => 'test@tenant.com',
        'phone' => '+39 123 456 789',
        'mobile' => '+39 987 654 321',
        'address' => 'Via Roma 123',
        'primary_color' => '#FF0000',
        'secondary_color' => '#00FF00',
    ], $overrides));
    $tenant->save();

    return $tenant;
}

test('tenant can be created', function (): void {
    $tenant = createPersistedTenant();

    Assert::assertInstanceOf(Tenant::class, $tenant);
    Assert::assertSame('test@tenant.com', $tenant->email_address);
    Assert::assertSame('+39 123 456 789', $tenant->phone);
    Assert::assertSame('+39 987 654 321', $tenant->mobile);
    Assert::assertSame('Via Roma 123', $tenant->address);
    Assert::assertSame('#FF0000', $tenant->primary_color);
    Assert::assertSame('#00FF00', $tenant->secondary_color);
});

test('tenant extends correct base class', function (): void {
    Assert::assertInstanceOf(BaseTenant::class, createPersistedTenant());
});

test('tenant has correct fillable attributes', function (): void {
    $fillable = createPersistedTenant()->getFillable();

    foreach (['id', 'name', 'slug', 'email_address', 'phone', 'mobile', 'address', 'primary_color', 'secondary_color'] as $attribute) {
        Assert::assertContains($attribute, $fillable);
    }
});

test('tenant has slug generated from name', function (): void {
    $tenant = createPersistedTenant();

    Assert::assertSame(Str::slug($tenant->name), $tenant->slug);
});

test('tenant slug is automatically generated', function (): void {
    $newTenant = TenantFactory::new()->createOne([
        'name' => 'Another Test Tenant',
    ]);

    Assert::assertSame('Another Test Tenant', $newTenant->name);
    Assert::assertNotSame('', (string) $newTenant->slug);
});

test('tenant has users relationship', function (): void {
    $tenant = createPersistedTenant();

    Assert::assertInstanceOf(BelongsToMany::class, $tenant->users());
});

test('tenant has members relationship', function (): void {
    $tenant = createPersistedTenant();

    Assert::assertInstanceOf(BelongsToMany::class, $tenant->members());
});

test('tenant implements required interfaces', function (): void {
    $reflection = new ReflectionClass(Tenant::class);

    Assert::assertTrue($reflection->implementsInterface(HasAvatar::class));
    Assert::assertTrue($reflection->implementsInterface(HasMedia::class));
    Assert::assertTrue($reflection->implementsInterface(TenantContract::class));
});

test('tenant has slug options configuration', function (): void {
    $tenant = createPersistedTenant();

    Assert::assertInstanceOf(SlugOptions::class, $tenant->getSlugOptions());
});

test('tenant has filament avatar url method', function (): void {
    $tenant = createPersistedTenant();

    if (! Schema::connection('media')->hasTable('media')) {
        Assert::assertTrue(is_callable([$tenant, 'getFilamentAvatarUrl']));

        return;
    }

    Assert::assertIsString($tenant->getFilamentAvatarUrl());
});

test('tenant can be found by slug', function (): void {
    $tenant = createPersistedTenant();
    $foundTenant = Tenant::where('slug', $tenant->slug)->first();

    Assert::assertInstanceOf(Tenant::class, $foundTenant);
    Assert::assertSame((string) $tenant->id, (string) $foundTenant->id);
    Assert::assertSame($tenant->name, $foundTenant->name);
});

test('tenant has correct table name', function (): void {
    Assert::assertSame('tenants', createPersistedTenant()->getTable());
});

test('tenant has correct primary key', function (): void {
    Assert::assertSame('id', createPersistedTenant()->getKeyName());
});

test('tenant has correct connection', function (): void {
    Assert::assertSame('user', createPersistedTenant()->getConnectionName());
});

test('tenant can be updated', function (): void {
    $tenant = createPersistedTenant();
    $originalId = (string) $tenant->id;
    $newName = 'Updated Tenant Name '.uniqid();

    $tenant->update([
        'name' => $newName,
        'email_address' => 'updated@tenant.com',
    ]);
    $tenant->refresh();

    Assert::assertSame($newName, $tenant->name);
    Assert::assertSame('updated@tenant.com', $tenant->email_address);
    Assert::assertSame(Str::slug($newName), $tenant->slug);
    Assert::assertSame($originalId, (string) $tenant->id);
});

test('tenant can be deleted', function (): void {
    $tenant = createPersistedTenant();
    $tenantId = (string) $tenant->id;

    if (! Schema::connection('media')->hasTable('media')) {
        DB::connection('user')->table('tenants')->where('id', $tenantId)->delete();
    } else {
        $tenant->delete();
    }

    Assert::assertNull(Tenant::find($tenantId));
});

test('can find tenant by name', function (): void {
    $name = 'Searchable Name '.uniqid();
    $tenant = TenantFactory::new()->createOne(['name' => $name]);
    $foundTenant = Tenant::where('name', $name)->first();

    Assert::assertInstanceOf(Tenant::class, $foundTenant);
    Assert::assertSame((string) $tenant->id, (string) $foundTenant->id);
});

test('can find active tenants', function (): void {
    TenantFactory::new()->createOne(['is_active' => true]);
    TenantFactory::new()->createOne(['is_active' => false]);

    $activeTenants = Tenant::where('is_active', true)->get();

    Assert::assertGreaterThanOrEqual(1, $activeTenants->count());
    foreach ($activeTenants as $activeTenant) {
        Assert::assertSame(1, $activeTenant->is_active);
    }
});

test('can find tenants by name pattern', function (): void {
    $baseName = 'PatternCompany '.uniqid();
    TenantFactory::new()->createOne(['name' => $baseName.' One']);
    TenantFactory::new()->createOne(['name' => $baseName.' Two']);

    $companyTenants = Tenant::where('name', 'like', '%'.$baseName.'%')->get();

    Assert::assertGreaterThanOrEqual(2, $companyTenants->count());
});
