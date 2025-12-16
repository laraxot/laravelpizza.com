<?php

declare(strict_types=1);

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Contracts\TenantContract;
use Modules\User\Models\BaseTenant;
use Modules\User\Models\Tenant;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->tenant = Tenant::factory()->create([
        'name' => 'Test Tenant',
        'email_address' => 'test@tenant.com',
        'phone' => '+39 123 456 789',
        'mobile' => '+39 987 654 321',
        'address' => 'Via Roma 123',
        'primary_color' => '#FF0000',
        'secondary_color' => '#00FF00',
    ]);
});

test('tenant can be created', function (): void {
    expect($this->tenant)->toBeInstanceOf(Tenant::class);
    expect($this->tenant->name)->toBe('Test Tenant');
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
    expect($this->tenant->slug)->toBe('test-tenant');
});

test('tenant slug is automatically generated', function (): void {
    $newTenant = Tenant::factory()->create([
        'name' => 'Another Test Tenant',
    ]);

    expect($newTenant->slug)->toBe('another-test-tenant');
});

test('tenant has users relationship', function (): void {
    expect($this->tenant)->toHaveMethod('users');

    $users = $this->tenant->users();
    expect($users)->toBeInstanceOf(BelongsToMany::class);
});

test('tenant has members relationship', function (): void {
    expect($this->tenant)->toHaveMethod('members');

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
    expect($this->tenant)->toHaveMethod('getSlugOptions');

    $slugOptions = $this->tenant->getSlugOptions();
    expect($slugOptions)->toBeInstanceOf(SlugOptions::class);
});

test('tenant has filament avatar url method', function (): void {
    expect($this->tenant)->toHaveMethod('getFilamentAvatarUrl');

    $avatarUrl = $this->tenant->getFilamentAvatarUrl();
    expect($avatarUrl)->toBeNull(); // Default implementation returns null
});

test('tenant can be found by slug', function (): void {
    $foundTenant = Tenant::where('slug', 'test-tenant')->first();

    expect($foundTenant)->not->toBeNull();
    expect($foundTenant->id)->toBe($this->tenant->id);
    expect($foundTenant->name)->toBe('Test Tenant');
});

test('tenant has correct table name', function (): void {
    expect($this->tenant->getTable())->toBe('tenants');
});

test('tenant has correct primary key', function (): void {
    expect($this->tenant->getKeyName())->toBe('id');
});

test('tenant has correct connection', function (): void {
    expect($this->tenant->getConnectionName())->toBe('default');
});

test('tenant can be updated', function (): void {
    $this->tenant->update([
        'name' => 'Updated Tenant Name',
        'email_address' => 'updated@tenant.com',
    ]);

    $this->tenant->refresh();

    expect($this->tenant->name)->toBe('Updated Tenant Name');
    expect($this->tenant->email_address)->toBe('updated@tenant.com');
    expect($this->tenant->slug)->toBe('updated-tenant-name');
});

test('tenant can be deleted', function (): void {
    $tenantId = $this->tenant->id;

    $this->tenant->delete();

    expect(Tenant::find($tenantId))->toBeNull();
});
