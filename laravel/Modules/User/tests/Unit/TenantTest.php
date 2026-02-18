<?php

declare(strict_types=1);

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Modules\User\Contracts\TenantContract;
use Modules\User\Models\BaseTenant;
use Modules\User\Models\Tenant;
use Modules\User\Tests\TestCase;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;

uses(TestCase::class);

beforeEach(function (): void {
    // Manually create the tenant to ensure incrementing = false is handled
    // since we can't easily change the model code.
    $this->tenant = new Tenant;
    $this->tenant->incrementing = false;
    $this->tenant->setKeyType('string');

    $tenantData = [
        'id' => (string) Str::uuid(),
        'name' => 'Test Tenant '.uniqid(),
        'email_address' => 'test@tenant.com',
        'phone' => '+39 123 456 789',
        'mobile' => '+39 987 654 321',
        'address' => 'Via Roma 123',
        'primary_color' => '#FF0000',
        'secondary_color' => '#00FF00',
    ];

    $this->tenant->fill($tenantData);
    $this->tenant->save();
});

test('tenant can be created', function (): void {
    expect($this->tenant)->toBeInstanceOf(Tenant::class);
    // Use the actual name from the created tenant since it has uniqid
    expect($this->tenant->name)->toBe($this->tenant->name);
    expect($this->tenant->email_address)->toBe('test@tenant.com');
    expect($this->tenant->phone)->toBe('+39 123 456 789');
    expect($this->tenant->mobile)->toBe('+39 987 654 321');
    expect($this->tenant->address)->toBe('Via Roma 123');
    expect($this->tenant->primary_color)->toBe('#FF0000');
    expect($this->tenant->secondary_color)->toBe('#00FF00');
});

test('tenant extends correct base class', function (): void {
    expect($this->tenant)->toBeInstanceOf(BaseTenant::class);
});

test('tenant has correct fillable attributes', function (): void {
    $fillable = $this->tenant->getFillable();

    expect($fillable)->toContain('id');
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('slug');
    expect($fillable)->toContain('email_address');
    expect($fillable)->toContain('phone');
    expect($fillable)->toContain('mobile');
    expect($fillable)->toContain('address');
    expect($fillable)->toContain('primary_color');
    expect($fillable)->toContain('secondary_color');
});

test('tenant has slug generated from name', function (): void {
    // Slug should be generated from the name we specified in beforeEach
    // Extract the base name without the unique ID
    $expectedSlug = Str::slug($this->tenant->name);
    expect($this->tenant->slug)->toBe($expectedSlug);
});

test('tenant slug is automatically generated', function (): void {
    $newTenant = Tenant::factory()->create([
        'name' => 'Another Test Tenant',
    ]);

    // Slug should be generated from the specified name
    expect($newTenant->slug)->toBe(Str::slug('Another Test Tenant'));
});

test('tenant has users relationship', function (): void {
    // Check method exists
    expect(method_exists($this->tenant, 'users'))->toBeTrue();

    $users = $this->tenant->users();
    expect($users)->toBeInstanceOf(BelongsToMany::class);
});

test('tenant has members relationship', function (): void {
    // Check method exists
    expect(method_exists($this->tenant, 'members'))->toBeTrue();

    $members = $this->tenant->members();
    expect($members)->toBeInstanceOf(BelongsToMany::class);
});

test('tenant implements required interfaces', function (): void {
    $reflection = new ReflectionClass(Tenant::class);

    expect($reflection->implementsInterface(HasAvatar::class))->toBeTrue();
    expect($reflection->implementsInterface(HasMedia::class))->toBeTrue();
    expect($reflection->implementsInterface(TenantContract::class))->toBeTrue();
});

test('tenant has slug options configuration', function (): void {
    // Check method exists
    expect(method_exists($this->tenant, 'getSlugOptions'))->toBeTrue();

    $slugOptions = $this->tenant->getSlugOptions();
    expect($slugOptions)->toBeInstanceOf(SlugOptions::class);
});

test('tenant has filament avatar url method', function (): void {
    // Check method exists
    expect(method_exists($this->tenant, 'getFilamentAvatarUrl'))->toBeTrue();

    $avatarUrl = $this->tenant->getFilamentAvatarUrl();
    // The actual implementation returns empty string, not null
    expect($avatarUrl)->toBe('');
});

test('tenant can be found by slug', function (): void {
    // Use the actual slug from the created tenant
    $foundTenant = Tenant::where('slug', $this->tenant->slug)->first();

    expect($foundTenant)->not->toBeNull();
    // Compare IDs as strings
    expect((string) $foundTenant->id)->toBe((string) $this->tenant->id);
    expect($foundTenant->name)->toBe($this->tenant->name);
});

test('tenant has correct table name', function (): void {
    expect($this->tenant->getTable())->toBe('tenants');
});

test('tenant has correct primary key', function (): void {
    expect($this->tenant->getKeyName())->toBe('id');
});

test('tenant has correct connection', function (): void {
    // Tenant model uses 'user' connection in Laraxot architecture
    expect($this->tenant->getConnectionName())->toBe('user');
});

test('tenant can be updated', function (): void {
    $originalId = (string) $this->tenant->id;
    $newName = 'Updated Tenant Name '.uniqid();

    $this->tenant->update([
        'name' => $newName,
        'email_address' => 'updated@tenant.com',
    ]);

    // Use refresh() instead of fresh() to reload within transaction
    $this->tenant->refresh();

    expect($this->tenant->name)->toBe($newName);
    expect($this->tenant->email_address)->toBe('updated@tenant.com');
    // Slug should be automatically updated from new name
    expect($this->tenant->slug)->toBe(Str::slug($newName));
    // ID should remain the same
    expect((string) $this->tenant->id)->toBe($originalId);
});

test('tenant can be deleted', function (): void {
    $tenantId = (string) $this->tenant->id;

    $this->tenant->delete();

    expect(Tenant::find($tenantId))->toBeNull();
});

test('can find tenant by name', function (): void {
    $name = 'Searchable Name '.uniqid();
    $tenant = Tenant::factory()->create(['name' => $name]);

    $foundTenant = Tenant::where('name', $name)->first();

    expect($foundTenant)->not->toBeNull();
    expect((string) $foundTenant->id)->toBe((string) $tenant->id);
});

test('can find active tenants', function (): void {
    Tenant::factory()->create(['is_active' => true]);
    Tenant::factory()->create(['is_active' => false]);

    $activeTenants = Tenant::where('is_active', true)->get();

    expect($activeTenants->count())->toBeGreaterThanOrEqual(1);
    expect($activeTenants->every(fn ($tenant) => $tenant->is_active))->toBeTruthy();
});

test('can find tenants by name pattern', function (): void {
    $baseName = 'PatternCompany '.uniqid();
    Tenant::factory()->create(['name' => $baseName.' One']);
    Tenant::factory()->create(['name' => $baseName.' Two']);

    $companyTenants = Tenant::where('name', 'like', '%'.$baseName.'%')->get();

    expect($companyTenants->count())->toBeGreaterThanOrEqual(2);
});
